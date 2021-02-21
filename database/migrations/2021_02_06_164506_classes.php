<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "Classes" stores classes input by a given teacher.
 */
class Classes extends Migration
{
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('archived')->default(0);
            $table->integer('ownerId')->unsigned();
            $table->foreign('ownerId')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
}
