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
        'company_id' => 'required|numeric|gte:0|exists:companies,id',
        'pv_id' => 'required|numeric|gte:0',
        'reference' => 'required',
        'confirmed_by' => 'required|numeric|gte:0',
        'authorized_by' => 'required|numeric|gte:0',
        'narration' => 'required',
        'total_amount' => 'required',
        'debit_account' => 'required|exists:org_bank_accounts,id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function pv()
    {
        return $this->belongsTo(PaymentVoucher::class, "pv_id", "id");
    }

    public function confirmed()
    {
        return $this->belongsTo(Staff::class, "confirmed_by", "id");
    }

    public function authorized()
    {
        return $this->belongsTo(Staff::class, "authorized_by", "id");
    }

    public function bankAccount()
    {
        return $this->belongsTo(OrgBankAccount::class, "bank_account", "id");
    }
}
