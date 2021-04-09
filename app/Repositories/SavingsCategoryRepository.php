<?php

namespace App\Repositories;

use App\Models\SavingsCategory;
use App\Repositories\BaseRepository;

/**
 * Class SavingsCategoryRepository
 * @package App\Repositories
 * @version February 20, 2021, 12:05 pm UTC
*/

class SavingsCategoryRepository extends BaseRepository
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
        return SavingsCategory::class;
    }
}
