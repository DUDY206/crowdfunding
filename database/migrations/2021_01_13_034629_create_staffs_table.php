<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('account_id');
            $table->unsignedSmallInteger('investment_id');
            $table->string('name')->nullable();
            $table->unsignedSmallInteger('position');
            $table->unsignedSmallInteger('description')->nullable();
            $table->boolean('is_chief');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
