<?php

namespace App\Repositories;

use App\Models\LoanCategory;
use App\Repositories\BaseRepository;

/**
 * Class LoanCategoryRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:07 pm UTC
*/

class LoanCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'category_id',
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
        return LoanCategory::class;
    }
}
