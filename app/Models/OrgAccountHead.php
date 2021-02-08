<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OrgAccountHead
 * @package App\Models
 * @version February 8, 2021, 5:59 pm UTC
 *
 * @property integer $company_id
 * @property integer $category_id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property boolean $active
 */
class OrgAccountHead extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'org_account_heads';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'category_id',
        'name',
        'slug',
        'code',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'category_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'code' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required|exists:companies,id',
        'category_id' => 'required|exists:org_account_categories,id',
        'name' => 'required',
        'slug' => 'required',
        'code' => 'required',
        'active' => 'required'
    ];

    
}
