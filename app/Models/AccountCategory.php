<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccountCategory
 * @package App\Models
 * @version February 8, 2021, 5:49 pm UTC
 *
 * @property string $name
 * @property integer $prefix_digit
 * @property string $account_type
 * @property string $slug
 */
class AccountCategory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'account_categories';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'prefix_digit',
        'account_type',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'prefix_digit' => 'integer',
        'account_type' => 'string',
        'slug' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'prefix_digit' => 'required|digits|min:1|max:9',
        'account_type' => 'required',
        'slug' => 'required'
    ];

    
}
