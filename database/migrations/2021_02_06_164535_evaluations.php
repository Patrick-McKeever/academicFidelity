<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "evaluations" is an implementation of various CCSD teacher evaluation forms.
 * 'evaluation' column will store various fields within the form, allowing us to store multiple types of forms.
 */
class Evaluations extends Migration
{
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->boolean('preObs');
            $table->json('evaluation')->nullable();
            $table->integer('creatorId')->unsigned();
            $table->foreign('creatorId')->references('id')->on('users');
            //'teacherId' references teacher being evaluated.
            $table->integer('teacherId')->unsigned();
            $table->foreign('teacherId')->references('id')->on('teachers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
