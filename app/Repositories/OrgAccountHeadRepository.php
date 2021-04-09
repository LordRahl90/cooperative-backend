<?php

namespace App\Repositories;

use App\Models\OrgAccountHead;
use App\Repositories\BaseRepository;

/**
 * Class OrgAccountHeadRepository
 * @package App\Repositories
 * @version February 8, 2021, 5:59 pm UTC
*/

class OrgAccountHeadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
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
        return OrgAccountHead::class;
    }
}
