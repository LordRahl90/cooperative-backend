<?php

namespace App\Repositories;

use App\Models\LoanRepayment;
use App\Repositories\BaseRepository;

/**
 * Class LoanRepaymentRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:33 pm UTC
*/

class LoanRepaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'loan_application_id',
        'customer_id',
        'count',
        'amount',
        'loan_id'
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
        return LoanRepayment::class;
    }
}
