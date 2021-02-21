<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A "group" is a collection of users who can share classes and query shared data.
 */
class Groups extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->boolean('archived')->default(0);
            $table->string('name');
            //'joinCode' allows users to join group.
            $table->string('joinCode');
            //'standards' allows group owner to set recommended standards for teachers to assess on.
            $table->json('standards')->nullable();
            //'SLGs' allows group owner to set standardized SLG.
            $table->json('slgs')->nullable();
            $table->integer('ownerId')->unsigned();
            $table->foreign('ownerId')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
