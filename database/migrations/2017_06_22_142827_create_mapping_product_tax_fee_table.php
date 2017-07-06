<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMappingProductTaxFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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

        Schema::table('company_products', function($table) {
            $table->integer('price')->default((int) 0);
        });

        Schema::table('merchant_products', function($table) {
            $table->integer('price')->default((int) 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapping_product_tax_fee');

        if (Schema::hasColumn('company_products', 'price'))
        {
            Schema::table('company_products', function($table) {
                $table->dropColumn('price');
            });
        }

        if (Schema::hasColumn('merchant_products', 'price'))
        {
            Schema::table('merchant_products', function($table) {
                $table->dropColumn('price');
            });
        }
    }
}
