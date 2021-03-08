<?php

namespace App\Repositories;

use App\Models\CustomerLoanLog;
use App\Repositories\BaseRepository;

/**
 * Class CustomerLoanLogRepository
 * @package App\Repositories
 * @version March 7, 2021, 3:01 pm UTC
*/

class CustomerLoanLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer',
        'loan_id',
        'debit',
        'credit'
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
        return CustomerLoanLog::class;
    }
}
