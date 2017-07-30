<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemittanceInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remittance_inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stan');
            $table->string('transdatetime');
            $table->string('instid');
            $table->string('proccode');
            $table->string('channeltype');
            $table->string('refnumber');
            $table->string('terminalid');
            $table->string('countrycode');
            $table->string('localdatetime');
            $table->string('accountid');
            $table->string('name');
            $table->string('currcode');
            $table->string('amount');
            $table->string('rate');
            $table->string('areacode');
            $table->string('instid2');
            $table->string('accountid2');
            $table->string('currcode2');
            $table->string('amount2');
            $table->string('custrefnumber');
            $table->string('regencycode');
            $table->string('purposecode');
            $table->string('purposedesc');
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
        Schema::dropIfExists('remittance_inquiries');
    }
}
