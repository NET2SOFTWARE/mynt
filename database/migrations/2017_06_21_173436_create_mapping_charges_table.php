<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMappingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapping_charges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('charge_id');
            $table->unsignedInteger('account_type_id');
            $table->unsignedInteger('account_id');
            $table->integer('amount')->default((int) 0);
            $table->foreign('service_id')
                ->references('id')
                ->on('services');
            $table->foreign('charge_id')
                ->references('id')
                ->on('charges');
            $table->foreign('account_type_id')
                ->references('id')
                ->on('account_types');
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
        Schema::dropIfExists('mapping_charges');
    }
}
