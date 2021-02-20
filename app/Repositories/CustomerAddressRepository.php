<?php

namespace App\Repositories;

use App\Models\CustomerAddress;
use App\Repositories\BaseRepository;

/**
 * Class CustomerAddressRepository
 * @package App\Repositories
 * @version February 20, 2021, 11:03 am UTC
*/

class CustomerAddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'customer_id',
        'street',
        'street2',
        'state',
        'country'
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
        return CustomerAddress::class;
    }
}
