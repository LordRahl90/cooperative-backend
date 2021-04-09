<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bank
 * @package App\Models
 * @version February 8, 2021, 6:05 pm UTC
 *
 * @property integer $country_id
 * @property string $name
 * @property string $slug
 * @property boolean $active
 */
class Bank extends Model
{
    use SoftDeletes;
    use Sluggable;
    use HasFactory;

    public $table = 'banks';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'country_id',
        'name',
        'slug',
        'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'country_id' => 'required|exists:countries,id',
        'name' => 'required',
        'active' => 'required'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
