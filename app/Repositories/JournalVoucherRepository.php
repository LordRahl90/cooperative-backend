<?php

namespace App\Repositories;

use App\Models\JournalVoucher;
use App\Repositories\BaseRepository;

/**
 * Class JournalVoucherRepository
 * @package App\Repositories
 * @version February 14, 2021, 11:39 am UTC
*/

class JournalVoucherRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'reference',
        'narration',
        'total_amount',
        'created_by'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JournalVoucher::class;
    }
}
