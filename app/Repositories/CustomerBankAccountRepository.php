<?php

namespace App\Repositories;

use App\Models\CustomerBankAccount;
use App\Repositories\BaseRepository;

/**
 * Class CustomerBankAccountRepository
 * @package App\Repositories
 * @version February 20, 2021, 4:50 pm UTC
*/

class CustomerBankAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'bank_id',
        'account_name',
        'account_number',
        'sort_code'
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
        return CustomerBankAccount::class;
    }
}
