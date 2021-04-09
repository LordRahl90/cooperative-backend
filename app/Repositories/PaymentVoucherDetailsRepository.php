<?php

namespace App\Repositories;

use App\Models\PaymentVoucherDetails;
use App\Repositories\BaseRepository;

/**
 * Class PaymentVoucherDetailsRepository
 * @package App\Repositories
 * @version February 8, 2021, 6:25 pm UTC
*/

class PaymentVoucherDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'pv_id',
        'account_head_id',
        'amount',
        'narration'
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
        return PaymentVoucherDetails::class;
    }
}
