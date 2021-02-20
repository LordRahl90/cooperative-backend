<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="JournalVoucher",
 *      required={"company_id", "reference", "narration", "total_amount", "created_by"},
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
 *          property="reference",
 *          description="reference",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="narration",
 *          description="narration",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="total_amount",
 *          description="total_amount",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="created_by",
 *          description="created_by",
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
class JournalVoucher extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'journal_vouchers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'company_id',
        'reference',
        'narration',
        'total_amount',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'reference' => 'string',
        'narration' => 'string',
        'total_amount' => 'double',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_id' => 'required|exists:companies,id',
        'reference' => 'required',
        'narration' => 'required',
        'total_amount' => 'required',
        'created_by' => 'required|exists:staff,id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, "created_by", "user_id");
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "reference", "reference");
    }
}
