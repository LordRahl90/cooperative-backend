<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Company",
 *      required={"name", "slug", "logo", "slogan", "email", "phone", "website", "address"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="logo",
 *          description="logo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slogan",
 *          description="slogan",
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
 *          property="website",
 *          description="website",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          description="address",
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
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Company extends Model
{
    use SoftDeletes;
    use Sluggable;
    use HasFactory;

    public $table = 'companies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
        'slug' => 'string',
        'logo' => 'string',
        'slogan' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'website' => 'string',
        'address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'slogan' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'website' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function country()
    {
        return $this->belongsTo(WorldCountry::class, "country_id", "id");
    }

    /**
     * @return HasMany
     **/
    public function configurations()
    {
        return $this->hasMany(Configuration::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function orgAccountCategories()
    {
        return $this->hasMany(OrgAccountCategory::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function orgAccountHeads()
    {
        return $this->hasMany(OrgAccountHead::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function paymentVoucherDetails()
    {
        return $this->hasMany(PaymentVoucherDetail::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function paymentVouchers()
    {
        return $this->hasMany(PaymentVoucher::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function payments()
    {
        return $this->hasMany(Payment::class, 'company_id');
    }

    /**
     * @return HasMany
     **/
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'company_id');
    }

    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
