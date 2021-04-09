<?php

namespace App\Repositories;

use App\Models\SavingsAccount;
use App\Repositories\BaseRepository;

/**
 * Class SavingsAccountRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:10 pm UTC
*/

class SavingsAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'savings_category_id',
        'account_head_id',
        'name',
        'slug',
        'description'
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
        return SavingsAccount::class;
    }
}
