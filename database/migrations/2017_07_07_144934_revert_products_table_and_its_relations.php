<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevertProductsTableAndItsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->dropColumn('price');
            # Should we implement default prices?
            # $table->renameColumn('price', 'default_sales_price');
            # $table->integer('default_tax')->default(0);
            # $table->integer('default_charge')->default(0);
        });

        Schema::table('company_products', function(Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('merchant_products', function(Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::dropIfExists('mapping_product_tax_fee');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->integer('price')->default(0);
        });

        Schema::table('company_products', function(Blueprint $table) {
            $table->integer('price')->default(0);
        });

        Schema::table('merchant_products', function(Blueprint $table) {
            $table->integer('price')->default(0);
        });

        Schema::create('mapping_product_tax_fee', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('product_id');
            $table->integer('tax')->default((int) 0);
            $table->integer('fee')->default((int) 0);
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->timestamps();
        });
    }
}
