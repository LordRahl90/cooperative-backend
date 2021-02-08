<?php

namespace App\Repositories;

use App\Models\Configuration;
use App\Repositories\BaseRepository;

/**
 * Class ConfigurationRepository
 * @package App\Repositories
 * @version February 8, 2021, 6:50 pm UTC
*/

class ConfigurationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'income_category',
        'expense_category',
        'cash_account_categories',
        'fixed_asset_categories',
        'current_assets_category',
        'account_payable_category',
        'account_recieveable_category'
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
        return Configuration::class;
    }
}
