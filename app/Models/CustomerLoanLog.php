<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CustomerLoanLog",
 *      required={"company_id", "customer", "loan_id", "debit", "credit"},
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
 *          property="customer",
 *          description="customer",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="loan_id",
 *          description="loan_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="debit",
 *          description="debit",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="credit",
 *          description="credit",
 *          type="number",
 *          format="number"
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
class CustomerLoanLog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customer_loan_logs';


    protected $dates = ['deleted_at'];


    public $guarded = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'customer_id' => 'integer',
        'loan_id' => 'integer',
        'debit' => 'double',
        'credit' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'customer_id' => 'required',
        'loan_id' => 'required',
        'debit' => 'required',
        'credit' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    public function loan()
    {
        return $this->belongsTo(CustomerLoan::class, "loan_id", "id");
    }
}
