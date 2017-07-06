<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('gender', ['male', 'female']);
            $table->string('born_place', (int) 40);
            $table->date('born_date');
            $table->unsignedInteger('identity_id');
            $table->foreign('identity_id')
                ->references('id')
                ->on('identities');
            $table->string('identity_number', 24);
            $table->date('identity_expired_date');
            $table->string('mother_name');
            $table->string('document')->default('document.jpg');
            $table->string('status');
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
        Schema::dropIfExists('profiles');
    }
}
