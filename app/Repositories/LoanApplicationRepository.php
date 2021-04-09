<?php

namespace App\Repositories;

use App\Models\LoanApplication;
use App\Repositories\BaseRepository;

/**
 * Class LoanApplicationRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:24 pm UTC
*/

class LoanApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'loan_account_id',
        'principal',
        'rate',
        'interest_type',
        'tenor',
        'status',
        'staff_id'
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
        return LoanApplication::class;
    }
}
