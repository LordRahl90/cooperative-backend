<?php

namespace App\Repositories;

use App\Models\PaymentVoucher;
use App\Repositories\BaseRepository;

/**
 * Class PaymentVoucherRepository
 * @package App\Repositories
 * @version February 8, 2021, 6:20 pm UTC
*/

class PaymentVoucherRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payee',
        'address',
        'email',
        'website',
        'phone',
        'pv_id'
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
        return PaymentVoucher::class;
    }
}
