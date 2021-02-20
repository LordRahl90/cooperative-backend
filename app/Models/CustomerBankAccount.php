<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CustomerBankAccount",
 *      required={"company_id", "customer_id", "bank_id", "account_name", "account_number", "sort_code"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="company_id",
 *          description="company_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="customer_id",
 *          description="customer_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="bank_id",
 *          description="bank_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="account_name",
 *          description="account_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="account_number",
 *          description="account_number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sort_code",
 *          description="sort_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class CustomerBankAccount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customer_bank_accounts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'customer_id',
        'bank_id',
        'account_name',
        'account_number',
        'sort_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'customer_id' => 'integer',
        'bank_id' => 'integer',
        'account_name' => 'string',
        'account_number' => 'string',
        'sort_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'customer_id' => 'required',
        'bank_id' => 'required',
        'account_name' => 'required',
        'account_number' => 'required',
        'sort_code' => 'required'
    ];

    
}
