<?php

namespace App\Repositories;

use App\Models\FeeManagement;
use App\Repositories\BaseRepository;

/**
 * Class FeeManagementRepository
 * @package App\Repositories
 * @version April 24, 2021, 12:59 pm WAT
*/

class FeeManagementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'description',
        'duration',
        'deadline',
        'amount',
        'account_head_id'
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
        return FeeManagement::class;
    }
}
