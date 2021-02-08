<?php

namespace App\Repositories;

use App\Models\AccountHead;
use App\Repositories\BaseRepository;

/**
 * Class AccountHeadRepository
 * @package App\Repositories
 * @version February 8, 2021, 5:53 pm UTC
*/

class AccountHeadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_id',
        'name',
        'slug',
        'code',
        'active'
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
        return AccountHead::class;
    }
}
