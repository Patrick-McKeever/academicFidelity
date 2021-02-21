<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A "group" is a collection of users who can share classes and query shared data.
 */
class GroupMembers extends Migration
{
    public function up()
    {
        Schema::create('groupMembers', function (Blueprint $table) {
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->integer('groupId')->unsigned();
            $table->foreign('groupId')->references('id')->on('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('groupMembers');
    }
}
