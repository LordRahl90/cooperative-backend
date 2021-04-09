<?php

namespace App\Repositories;

use App\Models\CustomerLoan;
use App\Repositories\BaseRepository;

/**
 * Class CustomerLoanRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:29 pm UTC
*/

class CustomerLoanRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'loan_application_id',
        'approved_by',
        'status',
        'total_repaid',
        'narration'
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
        return CustomerLoan::class;
    }
}
