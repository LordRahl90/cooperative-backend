<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanRepaymentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('loan_application_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->double('amount', 30, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('loan_application_id')->references('id')->on('loan_applications');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('loan_id')->references('id')->on('customer_loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_repayments');
    }
}
