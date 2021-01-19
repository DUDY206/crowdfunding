<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestMutableField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invest_mutable_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_id');
            $table->unsignedBigInteger('title');
            $table->unsignedBigInteger('content');
            $table->unsignedSmallInteger('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invest_mutable_fields');
    }
}
