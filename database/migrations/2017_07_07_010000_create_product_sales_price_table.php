<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSalesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales_price', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_purchase_price_id');
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('price');
            $table->foreign('product_purchase_price_id')
                ->references('id')
                ->on('product_purchase_price')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('merchant_id')
                ->references('id')
                ->on('merchants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['product_purchase_price_id', 'merchant_id']);
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
        Schema::dropIfExists('product_sales_price');
    }
}
