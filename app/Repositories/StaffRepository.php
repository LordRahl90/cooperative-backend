<?php

namespace App\Repositories;

use App\Models\Staff;
use App\Repositories\BaseRepository;

/**
 * Class StaffRepository
 * @package App\Repositories
 * @version February 12, 2021, 10:04 pm UTC
*/

class StaffRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'address'
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
        return Staff::class;
    }
}
