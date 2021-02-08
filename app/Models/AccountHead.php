<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccountHead
 * @package App\Models
 * @version February 8, 2021, 5:53 pm UTC
 *
 * @property integer $category_id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property bool $active
 */
class AccountHead extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'account_heads';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
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
        'category_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category_id' => 'required|exists:account_categories,id',
        'name' => 'required',
        'slug' => 'required',
        'code' => 'required',
        'active' => 'required'
    ];

    
}
