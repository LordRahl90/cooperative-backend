<?php

namespace App\Repositories;

use App\Models\CustomerTransaction;
use App\Repositories\BaseRepository;

/**
 * Class CustomerTransactionRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:36 pm UTC
*/

class CustomerTransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'savings_id',
        'loan_id',
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
        return CustomerTransaction::class;
    }
}
