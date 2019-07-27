<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',45);
            $table->string('lastname', 45)->nullable();
            $table->string('document',14);
            $table->string('streetNumber',45);
            $table->string('street',255);
            $table->string('city',255);
            $table->string('state', 3);
            $table->string('country', 3);
            $table->string('district', 255);
            $table->date('birthday');
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
        Schema::dropIfExists('people');
    }
}
