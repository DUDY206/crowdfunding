<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAtAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account', function (Blueprint $table) {
            $table->text('citizen_identification')->after('phone_number')->nullable();
            $table->date('card_date')->after('citizen_identification')->nullable();
            $table->text('card_address')->after('card_date')->nullable();
            $table->text('current_address')->after('card_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->text('citizen_identification');
            $table->date('card_date');
            $table->text('card_address');
            $table->text('current_address');
        });
    }
}
