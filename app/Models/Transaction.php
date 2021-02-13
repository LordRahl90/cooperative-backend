<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Transaction
 * @package App\Models
 * @version February 8, 2021, 6:36 pm UTC
 *
 * @property integer $company_id
 * @property integer $account_head_id
 * @property string $reference
 * @property string $narration
 * @property number $debit_amount
 * @property number $credit_amount
 * @property integer $created_by
 */
class Transaction extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'transactions';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'account_head_id',
        'reference',
        'narration',
        'debit_amount',
        'credit_amount',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'account_head_id' => 'integer',
        'reference' => 'string',
        'narration' => 'string',
        'debit_amount' => 'double',
        'credit_amount' => 'double',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required|exists:companies,id',
        'account_head_id' => 'required',
        'reference' => 'reequired|unique',
        'narration' => 'required',
        'debit_amount' => 'required',
        'credit_amount' => 'required',
        'created_by' => 'required'
    ];


}
