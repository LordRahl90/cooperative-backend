<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('loan_account_id')->unsigned();
            $table->double('principal', 30, 2);
            $table->double('rate', 10, 2);
            $table->double('repayment_amount', 10, 2)->nullable();
            $table->enum('interest_type', ['FLAT_RATE', 'REDUCING_BALANCE']);
            $table->integer('tenor');
            $table->enum('status', ['APPROVED', 'DISAPPROVED', 'PENDING'])->default('PENDING');
            $table->integer('staff_id')->unsigned();
            $table->integer('pv_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('loan_account_id')->references('id')->on('loan_accounts');
            $table->foreign('staff_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loan_applications');
    }
}
