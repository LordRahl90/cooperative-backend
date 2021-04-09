<?php

namespace App\Repositories;

use App\Models\OrgBankAccount;
use App\Repositories\BaseRepository;

/**
 * Class OrgBankAccountRepository
 * @package App\Repositories
 * @version February 8, 2021, 6:09 pm UTC
*/

class OrgBankAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bank_id',
        'account_name',
        'slug',
        'account_number',
        'account_head_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OrgBankAccount::class;
    }
}
