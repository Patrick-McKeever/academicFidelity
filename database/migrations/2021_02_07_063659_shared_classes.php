<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class sharedClasses extends Migration
{
    public function up()
    {
        Schema::create('sharedClasses', function (Blueprint $table) {
            $table->id();
            $table->integer('classId')->unsigned();
            $table->foreign('classId')->references('id')->on('classes');
            $table->integer('groupId')->unsigned();
            $table->foreign('groupId')->references('id')->on('groups');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sharedClasses');
    }
}
