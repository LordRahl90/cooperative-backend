<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Customer",
 *      required={"company_id", "surname", "othernames", "reference", "email", "phone", "gender", "password", "religion"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="company_id",
 *          description="company_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="surname",
 *          description="surname",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="othernames",
 *          description="othernames",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="reference",
 *          description="reference",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone",
 *          description="phone",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="gender",
 *          description="gender",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="password",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="religion",
 *          description="religion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Customer extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customers';


    protected $dates = ['deleted_at'];


    public $guarded = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'surname' => 'string',
        'othernames' => 'string',
        'reference' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'gender' => 'string',
        'password' => 'string',
        'religion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required|exists:companies,id',
        'surname' => 'required',
        'other_names' => 'required',
        'reference' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'gender' => 'required',
        'password' => 'required',
        'religion' => 'required'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
