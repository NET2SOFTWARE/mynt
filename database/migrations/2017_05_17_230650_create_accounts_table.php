<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number', 15)->unique()->index();
            $table->unsignedInteger('account_type_id');
            $table->foreign('account_type_id')
                        ->references('id')
                        ->on('account_types');
            $table->string('mynt_id', (int) 16)->unique()->nullable();
            $table->bigInteger('limit_balance')->nullable();
            $table->bigInteger('limit_balance_transaction')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
