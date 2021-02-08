<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OrgBankAccount
 * @package App\Models
 * @version February 8, 2021, 6:09 pm UTC
 *
 * @property integer $bank_id
 * @property string $account_name
 * @property string $slug
 * @property string $account_number
 * @property integer $account_head_id
 */
class OrgBankAccount extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'org_bank_accounts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'bank_id',
        'account_name',
        'slug',
        'account_number',
        'account_head_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'account_name' => 'string',
        'slug' => 'string',
        'account_number' => 'string',
        'account_head_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'bank_id' => 'required|exists:banks,id',
        'account_name' => 'required',
        'slug' => 'required',
        'account_number' => 'required',
        'account_head_id' => 'required|exists:org_account_heads,id'
    ];

    
}
