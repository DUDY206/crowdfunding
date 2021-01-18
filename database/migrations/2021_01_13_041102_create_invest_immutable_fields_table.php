<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestImmutableFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invest_immutable_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_id');
            $table->unsignedBigInteger('hight_light')->nullable();
            $table->unsignedBigInteger('overview_specialized')->nullable();
            $table->unsignedBigInteger('overview_company')->nullable();
            $table->unsignedBigInteger('financial_before')->nullable();
            $table->unsignedBigInteger('financial_after')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invest_immutable_fields');
    }
}
