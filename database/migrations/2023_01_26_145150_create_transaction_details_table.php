<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string("transaction_detail_code")->unique();
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('admin_banks_bank_id');
            $table->string('account_number');
            $table->string('admin_banks_account_number');
            $table->double('amount');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('admin_banks_bank_id')->references('id')->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
};
