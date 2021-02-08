<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PaymentVoucherDetails
 * @package App\Models
 * @version February 8, 2021, 6:25 pm UTC
 *
 * @property integer $company_id
 * @property integer $pv_id
 * @property integer $account_head_id
 * @property number $amount
 * @property string $narration
 */
class PaymentVoucherDetails extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payment_voucher_details';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'pv_id',
        'account_head_id',
        'amount',
        'narration'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'pv_id' => 'integer',
        'account_head_id' => 'integer',
        'amount' => 'double',
        'narration' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'pv_id' => 'required|exists:payment_vouchers,id',
        'account_head_id' => 'required|exists:org_account_heads,id',
        'amount' => 'required',
        'narration' => 'required'
    ];

    
}
