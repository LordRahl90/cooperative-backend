<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="CustomerAddress",
 *      required={"company_id", "customer_id", "street", "street2", "country"},
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
 *          property="customer_id",
 *          description="customer_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="street",
 *          description="street",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="street2",
 *          description="street2",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="state",
 *          description="state",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="country",
 *          description="country",
 *          type="integer",
 *          format="int32"
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
class CustomerAddress extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customer_addresses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_id',
        'customer_id',
        'street',
        'street2',
        'state',
        'country'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'customer_id' => 'integer',
        'street' => 'string',
        'street2' => 'string',
        'state' => 'integer',
        'country' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required',
        'customer_id' => 'required',
        'street' => 'required',
        'street2' => 'required',
        'state' => 'country integer select',
        'country' => 'required'
    ];

    
}
