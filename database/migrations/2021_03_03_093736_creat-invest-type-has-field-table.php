<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatInvestTypeHasFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_has_input_field', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invest_type_id');
            $table->unsignedBigInteger('contract_field_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_has_input_field');
    }
}
