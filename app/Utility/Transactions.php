<?php


namespace App\Utility;

use App\Models\CustomerLoan;
use App\Models\CustomerLoanLog;
use App\Models\CustomerSaving;
use App\Models\OrgBankAccount;
use App\Models\Payment;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Transactions
{

    /**
     * @param $companyID
     * @param $accountHead
     * @param $reference
     * @param $narration
     * @param $debit
     * @param $credit
     * @param $user
     * @return mixed
     */
    public static function transact($companyID, $accountHead, $reference, $narration, $debit, $credit, $user)
    {
        $transaction = Transaction::create([
            'company_id' => $companyID,
            'account_head_id' => $accountHead,
            'reference' => $reference,
            'narration' => $narration,
            'debit_amount' => $debit,
            'credit_amount' => $credit,
            'created_by' => $user
        ]);
        return $transaction;
    }


    /**
     * @param $companyID
     * @param $acctHead
     * @param $bankAccount
     * @param $reference
     * @param $narration
     * @param $amount
     * @param $payer
     * @param $user
     * @param string $phone
     * @param string $email
     * @return
     * @throws \Exception
     */
    public static function processIncome($companyID, $acctHead, $bankAccount, $reference, $narration, $amount, $payer, $user, $phone = "", $email = "")
    {
        DB::beginTransaction();
        try {

            if (Transaction::whereRaw('company_id=? and reference=?', [$companyID, $reference])->count() > 0) {
                throw new \Exception("This reference has been used for a transaction before, please reverse the previous transaction and re-post. " . $reference . "| " . $companyID);
            }

            $debit = self::transact($companyID, $acctHead, $reference, $narration, 0, $amount, $user);
            if (!$debit) {
                throw new \Exception("cannot create a credit entry for receiving payment " . $reference . ' ' . $user . ' ' . $amount);
            }
            $credit = self::transact($companyID, $bankAccount, $reference, $narration, $amount, 0, $user);
            if (!$credit) {
                throw new \Exception("cannot create a credit entry for receiving payment " . $reference . ' ' . $user . ' ' . $amount);
            }
            $receipt = Receipt::create([
                'company_id' => $companyID,
                'processed_by' => $user,
                'reference' => $reference,
                'payer' => $payer,
                'phone' => $phone,
                'email' => $email,
                'amount' => $amount
            ]);
            if (!$receipt) {
                throw new \Exception("cannot create a receipt entry for " . $reference);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
        return $receipt;
    }

    /**
     * @param $companyID
     * @param $pvID
     * @param $bankAccount
     * @param $reference
     * @param $narration
     * @param $amount
     * @param $confirmed
     * @param $authorized
     * @param $user
     * @return
     * @throws \Exception
     */
    public static function makePayment($companyID, $pvID, $bankAccount, $reference, $narration, $amount, $confirmed, $authorized, $user)
    {
        if (Payment::whereRaw('company_id=? and reference=?', [$companyID, $reference])->count() > 0) {
            throw new \Exception("This reference has been used for a transaction before, please reverse the previous transaction and re-post. " . $reference . "| " . $companyID);
        }

        DB::beginTransaction();
        try {
            $totalDebit = 0;
            $pvDetails = PaymentVoucher::find($pvID);
            foreach ($pvDetails->items as $item) {
                //Create Debit for each item
                $debit = self::transact($companyID, $item->account_head_id, $reference, $item->narration, $item->amount, 0, $user);
                if (!$debit) {
                    throw new \Exception("cannot create a debit entry for making payment " . $pvID . ' ' . $reference);
                }
                $totalDebit += $item->amount;
            }

            if ($totalDebit != $amount) {
                throw new \Exception("total amount paid to the bank doesn't equal the PV total amount.");
            }
            $bankAcc = OrgBankAccount::find($bankAccount);
            //create credit for the bank account
            $credit = self::transact($companyID, $bankAcc->account_head_id, $reference, $narration, 0, $amount, $user);
            if (!$credit) {
                throw new \Exception("cannot create a credit entry for making payment " . $pvID . ' ' . $reference);
            }

            $pvDetails->status = "PAID";
            if (!$pvDetails->save()) {
                throw new \Exception("cannot update the pv status. " . $pvDetails->id);
            }

            $paymentInfo = Payment::create([
                'pv_id' => $pvDetails->id,
                'company_id' => $companyID,
                'reference' => $reference,
                'confirmed_by' => $confirmed,
                'authorized_by' => $authorized,
                'total_amount' => $amount,
                'bank_account' => $bankAccount,
            ]);
            if (!$paymentInfo) {
                throw new \Exception("error creating entry for payment information. " . $pvDetails->id);
            }

            DB::commit();
            return $paymentInfo;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex);
            throw $ex;
        }
    }

    /**
     * @param $companyID
     * @param $reference
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    static function reverseReceipt($companyID, $reference, $user)
    {
        DB::beginTransaction();
        try {
            Transaction::whereRaw("company_id=? AND reference=?", [$companyID, $reference])->delete();
            Receipt::whereRaw('company_id=? AND reference=?', [$companyID, $reference])->delete();

            Log::info($user . " Reversed transaction " . $reference);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception($ex);
        }
    }

    /**
     * @param $companyID
     * @param $reference
     * @param $user
     * @throws \Exception
     */
    public static function reversePayment($companyID, $reference, $user)
    {
        DB::beginTransaction();
        try {
            $payment = Payment::whereRaw('company_id=? AND reference=?', [$companyID, $reference])->get();
            if (count($payment) == 0) {
                return;
            }
            $payment = $payment->first();
            $pv = PaymentVoucher::find($payment->pv_id);
            $pv->status = "UNPAID";
            if (!$pv->save()) {
                throw new \Exception("cannot update PV status");
            }

            Transaction::whereRaw("company_id=? AND reference=?", [$companyID, $reference])->delete();
            $payment->delete();

            Log::info($user . " Reversed payment " . $reference);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception($ex);
        }
    }

    /**
     * @param $loanID
     * @return int
     */
    public static function getLoanInterest($loanID)
    {
        $loan = CustomerLoan::with(['repayments', 'loan_application', 'logs'])->find($loanID);
        if ($loan->loan_application->interest_type === 'FLAT_RATE') {
            return 0;
        }
        $loanAmount = $loan->loan_application->principal;
        $repaidAmount = $loan->repayments->sum('principal');
        $rate = $loan->loan_application->rate;

        $newPrincipal = $loanAmount - $repaidAmount;
        $interest = $rate * $newPrincipal;
        return $interest;
    }

    public static function calculateMonthlyRepayment()
    {
        $customerLoans = CustomerLoan::with(['loan_application', 'logs', 'transactions'])->withCount(['transactions'])->where('status', 'RUNNING')->get();
        foreach ($customerLoans as $customerLoan) {
            $application = $customerLoan->loan_application;
            $loanAmount = $application->principal;
            $repaidAmount = $customerLoan->transactions->sum('credit'); // total amount repaid
            $repaymentAmount = $application->repayment_amount; // expected monthly principal repayment
            $now = Carbon::now();
            $year = $now->format('Y');
            $month = $now->format('m');
            $rate = $application->rate;

            //check if we have debited this customer account for this loan this month already
            $check = CustomerLoanLog::whereRaw('loan_id = ? and MONTH(created_at) = ? AND YEAR(created_at) = ?', [$customerLoan->id, $month, $year])->count();
            if ($check > 0) {
                Log::info("Amount payable has been calculated for this Loan account already " . $customerLoan->id);
                continue;
            }

            if ($application->interest_type === 'FLAT_RATE') {
                $payable = $repaymentAmount;
            } else {
                $interest = ($loanAmount - $repaidAmount) * $rate / 100;
                $payable = $repaymentAmount + $interest;
            }

            $debitCustomer = CustomerLoanLog::create([
                'company_id' => $customerLoan->company_id,
                'customer_id' => $customerLoan->customer_id,
                'loan_id' => $customerLoan->id,
                'reference' => strtoupper(uniqid('DB-')),
                'narration' => 'Loan repayment amount for ' . $month . ', ' . $year,
                'debit' => $payable,
                'credit' => 0,
            ]);

            if (!$debitCustomer) {
                Log::error("cannot create a debit record for " . $customerLoan->id);
            }

            Log::info("Customer Debited amount payable successfully.");
        }
    }

    /**
     *
     * calculates the next savings obligation for a given company
     *
     * @param $companyID
     * @return array
     */
    public static function calculateSavingsObligation($companyID)
    {
        $result = [];
        $customerSavings = CustomerSaving::where('company_id', $companyID)->get();
        foreach ($customerSavings as $customerSaving) {
            if (isset($result[$customerSaving->customer_id])) {
                $prevData = $result[$customerSaving->customer_id];
                $result[$customerSaving->customer_id] = $prevData + $customerSaving->amount;
            } else {
                $result[$customerSaving->customer_id] = $customerSaving->amount;
            }
        }
        return $result;
    }

    /**
     * Calculates the next loan obligation for a given company
     *
     * @param $companyID
     * @return array
     *
     */
    public static function calculateLoanObligation($companyID)
    {
        $result = [];
        $customerLoans = CustomerLoan::with(['loan_application', 'transactions'])->whereRaw('company_id=? AND status=?', [$companyID, 'RUNNING'])->get();
        foreach ($customerLoans as $customerLoan) {
            $application = $customerLoan->loan_application;
            $loanAmount = $application->principal;
            $rate = $application->rate;
            $repaidAmount = $customerLoan->transactions->sum('credit');
            $repaymentAmount = $application->repayment_amount;

            if ($application->interest_type === 'FLAT_RATE') {
                $payable = $repaymentAmount;
            } else {
                $interest = ($loanAmount - $repaidAmount) * $rate / 100;
                $payable = $repaymentAmount + $interest;
            }


            if (!isset($result[$customerLoan->customer_id])) {
                $result[$customerLoan->customer_id] = $payable;
            } else {
                $prevPayable = $result[$customerLoan->customer_id];
                $result[$customerLoan->customer_id] = $prevPayable + $payable;
            }
        }
        return $result;
    }

    /**
     * Calculates the monthly obligation for customers in a given company.
     *
     * @param $companyID
     * @return array
     */
    public static function calculateObligation($companyID)
    {
        $result = [];
        $savings = self::calculateSavingsObligation($companyID);
        $loans = self::calculateLoanObligation($companyID);

        foreach ($savings as $k => $v) {
            if (!isset($result[$k])) {
                $result[$k] = $v;
            } else {
                $oldResult = $result[$k];
                $result[$k] = $oldResult + $v;
            }
        }
        foreach ($loans as $k => $v) {
            if (!isset($result[$k])) {
                $result[$k] = $v;
            } else {
                $oldResult = $result[$k];
                $result[$k] = $oldResult + $v;
            }
        }
        return $result;
    }

    /**
     *This calculates obligations based on each user.
     *
     * It is achieved by summing the loan repayments and the savings obligation of the given customer
     *
     * @param $customerID
     * @return array
     */
    public static function calculateCustomerNextObligation($customerID)
    {
        $totalSavings = 0;
        $totalLoanRepayment = 0;
        $savings = CustomerSaving::where('customer_id', $customerID)->get();
        foreach ($savings as $saving) {
            $totalSavings += $saving->amount;
        }
        $loans = CustomerLoan::with(['loan_application', 'transactions'])->whereRaw('customer_id=? AND status=?', [$customerID, 'RUNNING'])->get();
        foreach ($loans as $loan) {
            $application = $loan->loan_application;
            $loanAmount = $application->principal;
            $rate = $application->rate;
            $repaidAmount = $loan->transactions->sum('credit');
            $repaymentAmount = $application->repayment_amount;

            if ($application->interest_type === 'FLAT_RATE') {
                $payable = $repaymentAmount;
            } else {
                $interest = ($loanAmount - $repaidAmount) * $rate / 100;
                $payable = $repaymentAmount + $interest;
            }

            $totalLoanRepayment += $payable;
        }

        return [
            "customer_id" => $customerID,
            "savings" => $totalSavings,
            "loans" => $totalLoanRepayment,
            "total" => $totalLoanRepayment + $totalSavings
        ];
    }

    public static function calculateLoanRepaymentAmount($loanID)
    {
        $loan = CustomerLoan::find($loanID);
        $application = $loan->loan_application;
        $loanAmount = $application->principal;
        $rate = $application->rate;
        $repaidAmount = $loan->transactions->sum('credit');
        $repaymentAmount = $application->repayment_amount;
        $interest = 0;

        if ($application->interest_type === 'FLAT_RATE') {
            $payable = $repaymentAmount;
        } else {
            $interest = ($loanAmount - $repaidAmount) * $rate / 100;
            $payable = $repaymentAmount + $interest;
        }

        return [
            'principal' => $repaymentAmount,
            'interest' => $interest
        ];
    }
}
