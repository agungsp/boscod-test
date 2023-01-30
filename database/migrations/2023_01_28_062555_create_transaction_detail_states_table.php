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
        Schema::create('transaction_detail_states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_detail_id');
            $table->unsignedInteger('state_code');
            $table->string('note', 255)->nullable();
            $table->timestamps();
            $table->foreign('transaction_detail_id')
                ->references('id')
                ->on('transaction_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_detail_states');
    }
};
