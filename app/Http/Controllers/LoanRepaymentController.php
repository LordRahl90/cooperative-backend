<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoanRepaymentRequest;
use App\Http\Requests\UpdateLoanRepaymentRequest;
use App\Jobs\ProcessRepaymentSchedule;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerLoan;
use App\Models\CustomerLoanLog;
use App\Models\CustomerTransaction;
use App\Models\OrgBankAccount;
use App\Repositories\LoanRepaymentRepository;
use App\Http\Controllers\AppBaseController;
use App\Utility\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Response;

class LoanRepaymentController extends AppBaseController
{
    /** @var  LoanRepaymentRepository */
    private $loanRepaymentRepository;

    public function __construct(LoanRepaymentRepository $loanRepaymentRepo)
    {
        $this->loanRepaymentRepository = $loanRepaymentRepo;
    }

    /**
     * Display a listing of the LoanRepayment.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request, $account)
    {
        $loanRepayments = $this->loanRepaymentRepository->where('company_id', session('company_id'));

        return view('loan_repayments.index', ['account' => $account])
            ->with('loanRepayments', $loanRepayments);
    }

    /**
     * Show the form for creating a new LoanRepayment.
     *
     * @return Response
     */
    public function create($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $companyID = session('company_id');
        $customers = Customer::orderBy('surname', 'asc')->where('company_id', $companyID)->get()->pluck('full_name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->where('company_id', $companyID)->pluck('account_name', 'id')->toArray();
        return view('loan_repayments.create', [
            'customers' => [0 => 'Select Customer'] + $customers->toArray(),
            'companies' => $companies,
            'account' => $account,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts
        ]);
    }

    /**
     * Store a newly created LoanRepayment in storage.
     *
     * @param CreateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanRepaymentRequest $request)
    {
        $input = $request->all();
//        dd($input);

        DB::beginTransaction();
        try {
            $companyID = $input['company_id'];
            $loanInfo = CustomerLoan::with(['loan_application.loan_account'])->find($input['loan_id']);
            $customer = $loanInfo->customer;
            $accountHead = $loanInfo->loan_application->loan_account->account_head_id;
            $bankAccount = $input['bank_account'];
            $reference = $input['reference'];
            $narration = $input['narration'];
            $principal = $input['principal'];
            $interest = $input['interest'];
            $amount = $principal + $interest;
            $bankAcc = OrgBankAccount::find($bankAccount);


            $trans = Transactions::processIncome($companyID, $accountHead, $bankAcc->account_head_id, $reference, $narration, $amount, $customer->full_name, auth()->id(), $customer->phone, $customer->email);
            if (!$trans) {
                throw new \Exception("cannot create the transaction record");
            }
            $loanRepayment = $this->loanRepaymentRepository->create([
                'company_id' => $companyID,
                'loan_application_id' => $loanInfo->loan_application_id,
                'loan_id' => $input['loan_id'],
                'customer_id' => $customer->id,
                'principal' => $principal,
                'interest' => $interest
            ]);

            if (!$loanRepayment) {
                throw new \Exception("cannot create the loan repayment record");
            }

            $newTransaction = CustomerTransaction::create([
                'company_id' => $companyID,
                'customer_id' => $customer->id,
                'loan_id' => $input['loan_id'],
                'debit' => 0.00,
                'credit' => $amount,
                'narration' => $narration,
                'reference' => $reference
            ]);

            if (!$newTransaction) {
                throw new \Exception("cannot create new customer transaction.");
            }

            $loanLog = CustomerLoanLog::create([
                'company_id' => $companyID,
                'customer_id' => $customer->id,
                'loan_id' => $input['loan_id'],
                'reference' => $reference,
                'narration' => $narration,
                'credit' => $amount,
                'debit' => 0.0
            ]);
            if (!$loanLog) {
                throw new \Exception('Cannot log this loan detail at the moment.');
            }

            DB::commit();
            return response()->redirectTo("/income/" . encrypt($reference) . "/receipt");

        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            Flash::error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($account, $id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index', $account));
        }

        return view('loan_repayments.show', ['account' => $account])->with('loanRepayment', $loanRepayment);
    }

    /**
     * Show the form for editing the specified LoanRepayment.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($account, $id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index', $account));
        }

        return view('loan_repayments.edit', ['account' => $account])->with('loanRepayment', $loanRepayment);
    }

    /**
     * Update the specified LoanRepayment in storage.
     *
     * @param int $id
     * @param UpdateLoanRepaymentRequest $request
     *
     * @return Response
     */
    public function update($account, $id, UpdateLoanRepaymentRequest $request)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index', $account));
        }

        $loanRepayment = $this->loanRepaymentRepository->update($request->all(), $id);

        Flash::success('Loan Repayment updated successfully.');

        return redirect(route('loanRepayments.index', $account));
    }

    /**
     * Remove the specified LoanRepayment from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($account, $id)
    {
        $loanRepayment = $this->loanRepaymentRepository->find($id);

        if (empty($loanRepayment)) {
            Flash::error('Loan Repayment not found');

            return redirect(route('loanRepayments.index', $account));
        }

        $this->loanRepaymentRepository->delete($id);

        Flash::success('Loan Repayment deleted successfully.');

        return redirect(route('loanRepayments.index', $account));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRepaymentSchedule($account)
    {
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        return view('loan_repayments.schedule', [
            'companies' => $companies,
            'account' => $account
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function repaymentSchedule(Request $request)
    {
        $companyID = $request->get('company_id');
        $startDate = $request->get('start_date');
        $results = Transactions::calculateObligation($companyID);

        if (count($results) == 0) {
            Flash::error("No customer registered for savings/loan at the moment");
            return redirect()->back()->withInput();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowCount = 1;
        $sheet->setCellValue('A' . $rowCount, 'Date');
        $sheet->setCellValue('B' . $rowCount, 'Staff Number');
        $sheet->setCellValue('C' . $rowCount, 'Full name');
        $sheet->setCellValue('D' . $rowCount, 'Amount');
        $sheet->getStyle('A' . $rowCount . ':' . 'D' . $rowCount)->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        foreach ($results as $k => $result) {
            $rowCount++;
            $customer = Customer::find($k);
            if (!$customer) {
                Log::error("Customer not found $k");
                continue;
            }

            $sheet->setCellValue('A' . $rowCount, Carbon::now()->format('d/m/Y'));
            $sheet->setCellValue('B' . $rowCount, $customer->reference);
            $sheet->setCellValue('C' . $rowCount, $customer->full_name);
            $sheet->setCellValue('D' . $rowCount, $result);
        }

        $f = public_path("/schedules/") . uniqid('sc-') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($f);

        return response()->download($f);
    }

    public function showUploadRepayment($account)
    {
        $companyID = session('company_id');
        $companies = Company::orderBy('name', 'asc')->pluck('name', 'id');
        $bankAccounts = OrgBankAccount::where('company_id', $companyID)->orderBy('account_name', 'asc')->pluck('account_name', 'id');

        return view('loan_repayments.upload', [
            'companies' => $companies,
            'account'=>$account,
            'bankAccounts' => [0 => 'Select Bank Account'] + $bankAccounts->toArray()
        ]);
    }

    public function uploadRepayment(Request $request)
    {
        $companyID = $request->company_id;
        $date = $request->start_date;
        $bankAccountID = $request->bank_account_id;
        $upload = $request->file('upload');
        if ($upload === null) {
            Flash::error("Invalid customer list, try again.");
            return redirect()->back();
        }
        $bankAccount = OrgBankAccount::find($bankAccountID);

        $filename = uniqid('cus-') . '.xlsx';
        $path = Storage::putFileAs('schedules', $upload, $filename);
        $filename = 'app/' . $path;
        ProcessRepaymentSchedule::dispatch($companyID, auth()->id(), $bankAccount->account_head_id, $filename, $date)->onQueue('repayment');

        Flash::success("Upload completed successfully, disbursing will start shortly.");
        return redirect()->back();
    }
}
