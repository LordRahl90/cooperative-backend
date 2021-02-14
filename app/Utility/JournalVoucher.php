<?php


namespace App\Utility;

use App\Models\OrgAccountHead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JournalVoucher
{
    /**
     * @param $companyID
     * @param $reference
     * @param $narration
     * @param $credits
     * @param $debits
     * @param $user
     * @return
     * @throws \Exception
     */
    public function create($companyID, $reference, $narration, $credits, $debits, $user)
    {
        if (\App\Models\JournalVoucher::where('reference', $reference)->count() > 0) {
            throw new \Exception("A JV with this reference exists already " . $reference);
        }
        DB::beginTransaction();
        try {
            $totalDebit = 0;
            $totalCredit = 0;

            if (count($debits) > 0) {
                foreach ($debits as $debit) {
                    $totalDebit += $debit['amount'];
                    $debitAccount = $this->getAccountHead($companyID, $debit['accountHead']);
                    $transaction = Transactions::transact($companyID, $debitAccount->id, $reference, $narration, $debit['amount'], 0, $user);
                    if (!$transaction) {
                        throw new \Exception("Cannot create a debit transaction entry for " . $reference);
                    }
                }
            }

            if (count($credits) > 0) {
                foreach ($credits as $credit) {
                    $totalCredit = $credit['amount'];
                    $creditAccount = $debitAccount = $this->getAccountHead($companyID, $credit['accountHead']);;
                    $transaction = Transactions::transact($companyID, $creditAccount->id, $reference, $narration, 0, $credit['amount'], $user);
                    if (!$transaction) {
                        throw new \Exception("Cannot create a debit transaction entry for " . $reference);
                    }
                }
            }

            if ($totalDebit === $totalCredit) {
                Log::info("error here");
                throw new \Exception("Total debit and credit amount doesn't match");
            }

            $jv = \App\Models\JournalVoucher::create([
                'company_id' => $companyID,
                'reference' => $reference,
                'narration' => $narration,
                'total_amount' => $totalDebit,
                'created_by' => $user
            ]);
            if (!$jv) {
                throw new \Exception("cannot create a new Journal Voucher Entry");
            }
            DB::commit();
            return $jv;
        } catch (\Exception $ex) {
            DB::rollBack();
        }
    }

    private function getAccountHead($companyID, $code)
    {
        $accountHead = OrgAccountHead::whereRaw('company_id=? and code=?', [$companyID, $code])->get();
        if (count($accountHead) == 0) {
            throw new \Exception("Invalid account head detected, please try again");
        }
        return $accountHead->first();
    }
}
