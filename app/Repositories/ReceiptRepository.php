<?php

namespace App\Repositories;

use App\Models\Receipt;
use App\Repositories\BaseRepository;

/**
 * Class ReceiptRepository
 * @package App\Repositories
 * @version February 13, 2021, 1:45 am UTC
*/

class ReceiptRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'reference',
        'payer',
        'phone',
        'email'
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
        return Receipt::class;
    }
}
