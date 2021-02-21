<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "classMembers" stores students who are input by teachers as members of a given class.
 * Student representations may be associated with email addresses.
 * This allows those students to log in and view data input by their teachers.
 * Note that, since multiple teachers may establish multiple representations of the same student,
 * the 'email' field is not unique.
 */
class ClassMembers extends Migration
{
    public function up()
    {
        Schema::create('classMembers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('classId')->unsigned();
            $table->foreign('classId')->references('id')->on('classes');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classMembers');
    }
}
