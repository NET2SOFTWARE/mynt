<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('credit')->default((int) 0);
            $table->bigInteger('debit')->default((int) 0);
            $table->bigInteger('balance')->default((int) 0);
            $table->unsignedInteger('transaction_id');
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passbooks');
    }
}
