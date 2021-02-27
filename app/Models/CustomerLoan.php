<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CustomerLoan",
 *      required={"company_id", "loan_application_id", "approved_by", "status", "total_repaid", "narration"},
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
 *          property="loan_application_id",
 *          description="loan_application_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="total_repaid",
 *          description="total_repaid",
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
class CustomerLoan extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customer_loans';


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
        'loan_application_id' => 'integer',
        'status' => 'string',
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
        'loan_application_id' => 'required|exists:loan_applications,id',
        'approved_by' => 'required',
        'status' => 'required',
        'debit_account' => 'required|exists:org_bank_accounts,id',
        'narration' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function loan_application()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, "approved_by", "id");
    }

}
