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



    public $fillable = [
        'company_id',
        'income_category',
        'expense_category',
        'cash_account_categories',
        'fixed_asset_categories',
        'current_assets_category',
        'account_payable_category',
        'account_recieveable_category'
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
        'cash_account_categories' => 'integer',
        'fixed_asset_categories' => 'integer',
        'current_assets_category' => 'integer',
        'account_payable_category' => 'integer',
        'account_recieveable_category' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'income_category' => 'required',
        'expense_category' => 'required',
        'cash_account_categories' => 'required',
        'fixed_asset_categories' => 'required',
        'current_assets_category' => 'required',
        'account_payable_category' => 'required',
        'account_recieveable_category' => 'required'
    ];

    
}
