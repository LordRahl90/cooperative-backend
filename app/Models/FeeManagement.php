<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FeeManagement
 * @package App\Models
 * @version April 24, 2021, 12:59 pm WAT
 *
 * @property integer $company_id
 * @property string $name
 * @property string $description
 * @property string $duration
 * @property string $deadline
 * @property number $amount
 * @property integer $account_head_id
 */
class FeeManagement extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'fee_managements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'name',
        'description',
        'duration',
        'deadline',
        'amount',
        'account_head_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'duration' => 'string',
        'deadline' => 'date',
        'amount' => 'double',
        'account_head_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required|exists:companies,id',
        'name' => 'required',
        'description' => 'required',
        'duration' => 'required',
        'deadline' => 'required',
        'amount' => 'required',
        'account_head_id' => 'required|exists:org_account_heads,id'
    ];

    
}
