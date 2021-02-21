<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 'Teachers' stores object representations of teachers who are evaluated in the evaluation form.
 * These may be but are not necessarily associated with user accounts who can view evaluations of themselves.
 * Since these teachers may not have accounts, this connection is made via the 'email' field.
 * As a result, multiple teacher objects may share the same email.
 */
class Teachers extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('school');
            $table->boolean('archived')->default(0);
            //'creatorId' gives the user who created this representation.
            $table->integer('creatorId')->unsigned();
            $table->foreign('creatorId')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
