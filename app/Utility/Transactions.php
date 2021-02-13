<?php


namespace App\Utility;


use App\Models\OrgBankAccount;
use App\Models\Payment;
use App\Models\PaymentVoucher;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Transactions
{
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


    public static function processIncome($companyID, $acctHead, $bankAccount, $reference, $narration, $amount, $user)
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

        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        DB::commit();
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

            dump("Total Debit: $totalDebit Amount: $amount");
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

    static function reverse($companyID, $reference)
    {
        return Transaction::whereRaw("company_id=? AND reference=?", [$companyID, $reference])->delete();
    }

}
