<?php

namespace App\Repositories;

use App\Models\LoanAccount;
use App\Repositories\BaseRepository;

/**
 * Class LoanAccountRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:14 pm UTC
*/

class LoanAccountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'loan_category_id',
        'account_head_id',
        'name',
        'slug',
        'code',
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
        return LoanAccount::class;
    }
}
