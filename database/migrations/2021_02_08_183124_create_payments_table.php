<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('pv_id')->unsigned();
            $table->string('reference');
            $table->integer('confirmed_by')->unsigned();
            $table->integer('authorized_by')->unsigned();
            $table->double('total_amount', 30, 2);
            $table->integer('bank_account')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('pv_id')->references('id')->on('payment_vouchers');
            $table->foreign('debit_account')->references('id')->on('org_bank_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
