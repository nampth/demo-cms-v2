<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('status')->default(USER_STATUS_INACTIVE);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('created_by')->nullable();
            $table->rememberToken();
            $table->text('metadata')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
