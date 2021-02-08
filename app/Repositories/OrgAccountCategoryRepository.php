<?php

namespace App\Repositories;

use App\Models\OrgAccountCategory;
use App\Repositories\BaseRepository;

/**
 * Class OrgAccountCategoryRepository
 * @package App\Repositories
 * @version February 8, 2021, 5:56 pm UTC
*/

class OrgAccountCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'slug',
        'account_type',
        'prefix_digit'
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
        return OrgAccountCategory::class;
    }
}
