<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductChargeFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_charge_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_charge_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('fee');
            $table->foreign('product_charge_id')
                ->references('id')
                ->on('product_charge')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('product_charge_fees');
    }
}
