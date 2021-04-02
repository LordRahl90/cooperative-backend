<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="LoanApplication",
 *      required={"company_id", "customer_id", "loan_account_id", "principal", "rate", "interest_type", "tenor", "status", "staff_id"},
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
 *          property="loan_account_id",
 *          description="loan_account_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="principal",
 *          description="principal",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="rate",
 *          description="rate",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="interest_type",
 *          description="interest_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="tenor",
 *          description="tenor",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="staff_id",
 *          description="staff_id",
 *          type="integer",
 *          format="int32"
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
class LoanApplication extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'loan_applications';


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
        'loan_account_id' => 'integer',
        'principal' => 'double',
        'rate' => 'double',
        'interest_type' => 'string',
        'tenor' => 'integer',
        'status' => 'string',
        'staff_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'customer_id' => 'required',
        'loan_account_id' => 'required',
        'principal' => 'required',
        'rate' => 'required',
        'interest_type' => 'required',
        'tenor' => 'required',
        'status' => 'required',
        'staff_id' => 'required',
        'repayment_amount' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loan_account()
    {
        return $this->belongsTo(LoanAccount::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'user_id');
    }

    public function pv()
    {
        return $this->belongsTo(PaymentVoucher::class, "pv_id", "id");
    }

    public function loan()
    {
        return $this->hasOne(CustomerLoan::class, "loan_application_id", "id");
    }

    public function approver()
    {
        return $this->belongsTo(Staff::class, "approved_by", "id");
    }
}
