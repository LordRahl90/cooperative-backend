<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Configuration
 * @package App\Models
 * @version February 8, 2021, 6:50 pm UTC
 *
 * @property integer $company_id
 * @property integer $income_category
 * @property integer $expense_category
 * @property integer $cash_account_categories
 * @property integer $fixed_asset_categories
 * @property integer $current_assets_category
 * @property integer $account_payable_category
 * @property integer $account_recieveable_category
 */
class Configuration extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'configurations';


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
        'income_category' => 'integer',
        'expense_category' => 'integer',
        'cash_account_category' => 'integer',
        'fixed_asset_category' => 'integer',
        'current_assets_category' => 'integer',
        'account_payable_category' => 'integer',
        'account_receivable_category' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function income()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'income_category', 'id');
    }

    public function expense()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'expense_category', 'id');
    }

    public function cash_account()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'cash_account_category', 'id');
    }

    public function fixed_asset()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'fixed_asset_category', 'id');
    }

    public function current_asset()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'current_assets_category', 'id');
    }

    public function current_liability()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'current_liability_category', 'id');
    }

    public function account_payable()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'account_payable_category', 'id');
    }

    public function account_receivable()
    {
        return $this->belongsTo(OrgAccountCategory::class, 'account_receivable_category', 'id');
    }

}
