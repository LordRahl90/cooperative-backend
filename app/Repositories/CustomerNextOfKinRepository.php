<?php

namespace App\Repositories;

use App\Models\CustomerNextOfKin;
use App\Repositories\BaseRepository;

/**
 * Class CustomerNextOfKinRepository
 * @package App\Repositories
 * @version February 20, 2021, 11:05 am UTC
*/

class CustomerNextOfKinRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'name',
        'address',
        'phone',
        'email',
        'relationship'
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
        return CustomerNextOfKin::class;
    }
}
