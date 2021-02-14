<?php


namespace App\Utility;

use App\Models\OrgBankAccount;
use App\Models\Payment;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use App\Models\Transaction;
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
     * @return mixed
     */
    static function reverseIncome($companyID, $reference)
    {
        return Transaction::whereRaw("company_id=? AND reference=?", [$companyID, $reference])->delete();
    }

    static function reversePayment($companyID, $reference)
    {
        return Transaction::whereRaw("company_id=? AND reference=?", [$companyID, $reference])->delete();
    }

}
