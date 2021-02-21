<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "passwordResets" is for the "forgot password" functionality.
 */
class PasswordResets extends Migration
{
    public function up()
    {
        Schema::create('passwordResets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passwordResets');
    }
}
