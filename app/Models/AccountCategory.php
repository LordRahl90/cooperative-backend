<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
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
    use Sluggable;

    public $table = 'account_categories';


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
        'account_type' => 'required'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
