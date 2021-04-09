<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerNextOfKin;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory(10)->create(['company_id' => 1])->each(function ($customer) {
            CustomerAddress::factory()->create(['customer_id' => $customer->id, 'company_id' => $customer->company_id]);
            CustomerNextOfKin::factory()->create(['customer_id' => $customer->id, 'company_id' => $customer->company_id]);
        });
    }
}
