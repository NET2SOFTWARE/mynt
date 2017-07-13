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
            $table->date('transdatetime');
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
            $table->string('name1', 30)->nullable();
            $table->string('relationship1', 30)->nullable();
            $table->string('regencycode1', 3)->nullable();
            $table->string('address1', 100)->nullable();
            $table->string('provcode1', 5)->nullable();
            $table->string('idnumber1', 50)->nullable();

            $table->string('instid2', 3)->nullable();
            $table->string('name2', 30)->nullable();
            $table->string('relationship2', 30)->nullable();
            $table->string('regencycode2', 3)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('provcode2', 5)->nullable();
            $table->string('idnumber2', 50)->nullable();

            $table->string('instid3', 3)->nullable();
            $table->string('name3', 30)->nullable();
            $table->string('relationship3', 30)->nullable();
            $table->string('regencycode3', 3)->nullable();
            $table->string('address3', 100)->nullable();
            $table->string('provcode3', 5)->nullable();
            $table->string('idnumber3', 50)->nullable();

            $table->string('instid4', 3)->nullable();
            $table->string('name4', 30)->nullable();
            $table->string('relationship4', 30)->nullable();
            $table->string('regencycode4', 3)->nullable();
            $table->string('address4', 100)->nullable();
            $table->string('provcode4', 5)->nullable();
            $table->string('idnumber4', 50)->nullable();

            $table->string('instid5', 3)->nullable();
            $table->string('name5', 30)->nullable();
            $table->string('relationship5', 30)->nullable();
            $table->string('regencycode5', 3)->nullable();
            $table->string('address5', 100)->nullable();
            $table->string('provcode5', 5)->nullable();
            $table->string('idnumber5', 50)->nullable();

            $table->longText('sign');
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
