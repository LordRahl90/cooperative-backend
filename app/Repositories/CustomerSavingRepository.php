<?php

namespace App\Repositories;

use App\Models\CustomerSaving;
use App\Repositories\BaseRepository;

/**
 * Class CustomerSavingRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:18 pm UTC
*/

class CustomerSavingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'savings_account_id',
        'amount',
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
        return CustomerSaving::class;
    }
}
