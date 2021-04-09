<?php


namespace App\Utility;


use App\Models\OrgAccountHead;
use App\Models\OrgBankAccount;

class Utility
{
    public static function getAccountHeads($companyID)
    {
        $bankAccounts = OrgBankAccount::where("company_id", $companyID)->get('account_head_id');
        $acctHeadIDs = [];

        foreach ($bankAccounts as $v) {
            $acctHeadIDs[] = $v->account_head_id;
        }
        return OrgAccountHead::where("company_id", $companyID)->whereNotIn('id', $acctHeadIDs)->pluck('name', 'id');
    }

}
