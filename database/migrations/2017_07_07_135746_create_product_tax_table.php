<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tax', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_sales_price_id');
            $table->unsignedInteger('tax');
            $table->foreign('product_sales_price_id')
                ->references('id')
                ->on('product_sales_price')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique('product_sales_price_id');
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
        Schema::dropIfExists('product_tax');
    }
}
