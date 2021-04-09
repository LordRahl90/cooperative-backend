<?php

namespace App\Repositories;

use App\Models\LoanGuarator;
use App\Repositories\BaseRepository;

/**
 * Class LoanGuaratorRepository
 * @package App\Repositories
 * @version March 14, 2021, 3:21 pm UTC
*/

class LoanGuaratorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'loan_id',
        'guarantor'
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
        return LoanGuarator::class;
    }
}
