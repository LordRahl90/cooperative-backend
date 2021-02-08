<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Payment
 * @package App\Models
 * @version February 8, 2021, 6:31 pm UTC
 *
 * @property integer $company_id
 * @property integer $pv_id
 * @property string $reference
 * @property integer $confirmed_by
 * @property integer $authorized_by
 * @property number $total_amount
 * @property integer $debit_account
 */
class Payment extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'payments';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'pv_id',
        'reference',
        'confirmed_by',
        'authorized_by',
        'total_amount',
        'debit_account'
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
        'reference' => 'string',
        'confirmed_by' => 'integer',
        'authorized_by' => 'integer',
        'total_amount' => 'double',
        'debit_account' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'pv_id' => 'required',
        'reference' => 'required|unique',
        'confirmed_by' => 'required',
        'authorized_by' => 'required',
        'total_amount' => 'required',
        'debit_account' => 'required'
    ];

    
}
