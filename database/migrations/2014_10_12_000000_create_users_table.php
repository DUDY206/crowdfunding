<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->unique();
            $table->string('full_name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->date('date_of_birth');
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('description')->nullable();
            $table->string('slogan')->nullable();
            $table->boolean('is_verify')->default(0);
            $table->boolean('is_reliable_investor')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('account');
    }
}
