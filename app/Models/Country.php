<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Country
 * @package App\Models
 * @version February 8, 2021, 6:03 pm UTC
 *
 * @property string $name
 * @property string $slug
 * @property string $code
 */
class Country extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'countries';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'slug',
        'code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
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
        'name' => 'required',
        'slug' => 'required',
        'code' => 'required'
    ];

    
}
