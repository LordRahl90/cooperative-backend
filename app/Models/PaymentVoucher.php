<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PaymentVoucher
 * @package App\Models
 * @version February 8, 2021, 6:20 pm UTC
 *
 * @property string $payee
 * @property string $address
 * @property string $email
 * @property string $website
 * @property string $phone
 * @property string $pv_id
 */
class PaymentVoucher extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payment_vouchers';


    protected $dates = ['deleted_at'];


    public $guarded = [
        'deleted_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payee' => 'string',
        'address' => 'string',
        'email' => 'string',
        'website' => 'string',
        'phone' => 'string',
        'pv_id' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(PaymentVoucherDetails::class, "pv_id", "id");
    }
}
