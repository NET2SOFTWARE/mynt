<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remittances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stan', 6);
            $table->dateTime('transdatetime');
            $table->string('instid', 18);
            $table->string('accountid', 18);
            $table->string('name', 30);
            $table->string('address', 100);
            $table->string('countrycode', 2);
            $table->date('birthdate');
            $table->string('birthplace', 30);
            $table->string('phonenumber', 15);
            $table->string('email', 30);
            $table->string('occupation', 50);
            $table->string('citizenship', 30);
            $table->string('idnumber', 50);
            $table->string('fundresource', 50);

            $table->string('instid1', 3)->nullable();
            $table->string('accountid1', 18)->nullable();
            $table->string('name1', 30)->nullable();
            $table->string('relationship1', 30)->nullable();
            $table->string('regencycode1', 3)->nullable();
            $table->string('address1', 100)->nullable();
            $table->string('provcode1', 5)->nullable();
            $table->string('idnumber1', 50)->nullable();

            $table->longText('sign');
            $table->unsignedInteger('bank_id');
            $table->foreign('bank_id')
                ->references('id')
                ->on('banks');
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
        Schema::dropIfExists('remittances');
    }
}
