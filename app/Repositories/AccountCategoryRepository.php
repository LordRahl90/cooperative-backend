<?php

namespace App\Repositories;

use App\Models\AccountCategory;
use App\Repositories\BaseRepository;

/**
 * Class AccountCategoryRepository
 * @package App\Repositories
 * @version February 8, 2021, 5:49 pm UTC
*/

class AccountCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'prefix_digit',
        'account_type',
        'slug'
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
        return AccountCategory::class;
    }
}
