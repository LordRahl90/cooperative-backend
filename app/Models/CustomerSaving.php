<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CustomerSaving",
 *      required={"company_id", "customer_id", "savings_account_id", "amount", "narration"},
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
 *          property="savings_account_id",
 *          description="savings_account_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="narration",
 *          description="narration",
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
class CustomerSaving extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customer_savings';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'customer_id',
        'savings_account_id',
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
        'customer_id' => 'integer',
        'savings_account_id' => 'integer',
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
        'customer_id' => 'required',
        'savings_account_id' => 'required',
        'amount' => 'required',
        'narration' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function savings()
    {
        return $this->belongsTo(SavingsAccount::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
