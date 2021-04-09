<?php

namespace App\Jobs;

use App\Mail\LoanRepaymentUpload;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerLoanLog;
use App\Models\CustomerSaving;
use App\Models\CustomerTransaction;
use App\Models\LoanRepayment;
use App\Models\ProcessedLoanRepaymentUpload;
use App\Models\Staff;
use App\Utility\Transactions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ProcessRepaymentSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $companyID;
    public $staffID;
    public $bankAccountID;
    public $filename;
    public $date;

    /**
     * Create a new job instance.
     *
     * @param $companyID
     * @param $staffID
     * @param $bankAccountID
     * @param $filename
     * @param $date
     */
    public function __construct($companyID, $staffID, $bankAccountID, $filename, $date)
    {
        $this->companyID = $companyID;
        $this->staffID = $staffID;
        $this->bankAccountID = $bankAccountID;
        $this->date = $date;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(storage_path($this->filename));
        $sheet = $spreadsheet->getActiveSheet();
        $success = [];
        $failed = [];
        $incompleteAmount = [];
        $invalidCustomerRef = [];
        $duplicates = [];


        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $customerRef = $sheet->getCellByColumnAndRow(2, $row)->getValue();
            $amount = $sheet->getCellByColumnAndRow(4, $row)->getValue();

            $customer = Customer::where('company_id', $this->companyID)->where('reference', $customerRef)->get();
            if (count($customer) == 0) {
                //TODO: Notify that this customer's record is invalid
                Log::error("invalid record found $customerRef");
                $invalidCustomerRef[] = $customerRef;
                continue;
            }
            $customer = $customer->first();

            $check = ProcessedLoanRepaymentUpload::whereRaw('company_id=? AND customer_id=? AND month=? AND year=? AND amount=?', [
                $this->companyID,
                $customer->id,
                Date('m'),
                Date('Y'),
                $amount
            ])->count();

            if ($check > 0) {
                $duplicates[] = ['customer_id' => $customer->id, 'ref' => $customer->reference,
                    'customer' => $customer->full_name, 'paid' => $amount, 'message' => 'possible duplicate'];
                continue;
            }

            $customerPayable = Transactions::calculateCustomerNextObligation($customer->id);
            $total = $customerPayable['total'];
            if (doubleval($amount) != doubleval($total)) {
                Log::error("The amount paid doesn't match the amount payable. CompanyID: $this->companyID customerID: $customer->id StaffID: $customerRef");
                $incompleteAmount[] = ['customer_id' => $customer->id, 'ref' => $customer->reference,
                    'customer' => $customer->full_name, 'payable' => $customerPayable['total'],
                    'paid' => $amount, 'message' => 'incomplete amount deducted from source.'];
                continue;
            }

            DB::beginTransaction();
            try {
                // get all the customer's savings
                $savings = CustomerSaving::where('customer_id', $customer->id)->get();
                foreach ($savings as $saving) {
                    // save savings payment record
                    $accountHead = $saving->savings->account_head_id;
                    $ref = strtoupper(uniqid('upl-'));
                    $narration = 'Savings for ' . Date('M, Y');
                    $trans = Transactions::processIncome($this->companyID, $accountHead, $this->bankAccountID, $ref, $narration, $amount, $customer->full_name, $this->staffID, $customer->phone, $customer->email);
                    if (!$trans) {
                        throw new \Exception("cannot create the transaction record");
                    }

                    $newTransaction = CustomerTransaction::create([
                        'company_id' => $this->companyID,
                        'customer_id' => $customer->id,
                        'savings_id' => $saving->id,
                        'credit' => $amount,
                        'debit' => 0.00,
                        'narration' => $narration,
                        'reference' => $ref
                    ]);

                    if (!$newTransaction) {
                        throw new \Exception("cannot create new customer transaction.");
                    }
                }

                $loans = CustomerLoan::with(['loan_application', 'transactions'])->whereRaw('customer_id=? AND status=?', [$customer->id, 'RUNNING'])->get();
                foreach ($loans as $loan) {
                    //save loan repayment record.

                    $ref = strtoupper(uniqid('upl-'));
                    $narration = 'Loan repayment for ' . Date('M, Y');
                    $application = $loan->loan_application;
                    $accountHead = $application->loan_account->account_head_id;
                    $expectedRepayment = Transactions::calculateLoanRepaymentAmount($loan->id);
                    $totalRepayment = $expectedRepayment['principal'] + $expectedRepayment['interest'];

                    $trans = Transactions::processIncome($this->companyID, $accountHead, $this->bankAccountID, $ref, $narration, $amount, $customer->full_name, $this->staffID, $customer->phone, $customer->email);
                    if (!$trans) {
                        throw new \Exception("cannot create the transaction record");
                    }

                    $loanRepayment = LoanRepayment::create([
                        'company_id' => $this->companyID,
                        'loan_application_id' => $application->id,
                        'loan_id' => $loan->id,
                        'customer_id' => $customer->id,
                        'principal' => $expectedRepayment['principal'],
                        'interest' => $expectedRepayment['interest']
                    ]);

                    if (!$loanRepayment) {
                        throw new \Exception("cannot create the loan repayment record");
                    }

                    $newTransaction = CustomerTransaction::create([
                        'company_id' => $this->companyID,
                        'customer_id' => $customer->id,
                        'loan_id' => $loan->id,
                        'debit' => 0.00,
                        'credit' => $totalRepayment,
                        'narration' => $narration,
                        'reference' => $ref
                    ]);

                    if (!$newTransaction) {
                        throw new \Exception("cannot create new customer transaction.");
                    }

                    $loanLog = CustomerLoanLog::create([
                        'company_id' => $this->companyID,
                        'customer_id' => $customer->id,
                        'loan_id' => $loan->id,
                        'reference' => $ref,
                        'narration' => $narration,
                        'credit' => $totalRepayment,
                        'debit' => 0.0
                    ]);
                    if (!$loanLog) {
                        throw new \Exception('Cannot log this loan detail at the moment.');
                    }
                }

            } catch (\Exception $ex) {
                Log::info($ex);
                DB::rollBack();
                $failed[] = ['customer_id' => $customer->id, 'ref' => $customer->reference, 'customer' => $customer->full_name, 'message' => $ex->getMessage()];
                //TODO: Mail that an issue has occurred with this posting, and someone should look into it.
                continue;
            }
            $success[] = ['customer_id' => $customer->id, 'ref' => $customer->reference, 'customer' => $customer->full_name, 'payable' => $total, 'paid' => $amount, 'message' => 'disbursed successfully'];
            // keep the customer information locked so we don't attempt to recreate it
            $processed = ProcessedLoanRepaymentUpload::create([
                'company_id' => $this->companyID,
                'staff_id' => $this->staffID,
                'customer_id' => $customer->id,
                'month' => Date('m'),
                'year' => Date('Y'),
                'amount' => $amount,
                'filename' => $this->filename
            ]);

            DB::commit();
        }
        Mail::to('tolaabbey009@gmail.com')->send(new LoanRepaymentUpload($this->staffID, $success, $failed, $incompleteAmount, $invalidCustomerRef, $duplicates));
    }
}
