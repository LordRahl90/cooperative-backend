<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('income_category')->unsigned()->nullable();
            $table->integer('bank_category')->unsigned()->nullable();
            $table->integer('expense_category')->unsigned()->nullable();
            $table->integer('cash_account_category')->unsigned()->nullable();
            $table->integer('fixed_asset_category')->unsigned()->nullable();
            $table->integer('current_assets_category')->unsigned()->nullable();
            $table->integer('current_liability_category')->unsigned()->nullable();
            $table->integer('account_payable_category')->unsigned()->nullable();
            $table->integer('account_receivable_category')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('income_category')->references('id')->on('org_account_categories');
            $table->foreign('bank_category')->references('id')->on('org_account_categories');
            $table->foreign('expense_category')->references('id')->on('org_account_categories');
            $table->foreign('cash_account_category')->references('id')->on('org_account_categories');
            $table->foreign('fixed_asset_category')->references('id')->on('org_account_categories');
            $table->foreign('current_assets_category')->references('id')->on('org_account_categories');
            $table->foreign('current_liability_category')->references('id')->on('org_account_categories');
            $table->foreign('account_payable_category')->references('id')->on('org_account_categories');
            $table->foreign('account_receivable_category')->references('id')->on('org_account_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configurations');
    }
}
