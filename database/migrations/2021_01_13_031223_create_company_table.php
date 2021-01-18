<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('description')->nullable();
            $table->string('img_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('legal_name')->nullable();
            $table->date('founded')->nullable();
            $table->unsignedBigInteger('company_type')->nullable();
            $table->smallInteger('total_employees')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('location')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
