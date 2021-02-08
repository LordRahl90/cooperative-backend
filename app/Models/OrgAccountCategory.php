<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OrgAccountCategory
 * @package App\Models
 * @version February 8, 2021, 5:56 pm UTC
 *
 * @property integer $company_id
 * @property string $name
 * @property string $slug
 * @property string $account_type
 * @property integer $prefix_digit
 */
class OrgAccountCategory extends Model
{
    use SoftDeletes;
    use Sluggable;
    use HasFactory;

    public $table = 'org_account_categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'name',
        'slug',
        'account_type',
        'prefix_digit'
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
        'slug' => 'string',
        'account_type' => 'string',
        'prefix_digit' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'name' => 'required',
        'account_type' => 'required',
        'prefix_digit' => 'required'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
