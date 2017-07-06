<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMappingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mapping_charge_id');
            $table->unsignedInteger('account_id');
            $table->integer('amount')->default((int) 0);
            $table->foreign('mapping_charge_id')
                ->references('id')
                ->on('mapping_charges');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
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
        Schema::dropIfExists('mapping_fees');
    }
}
