<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('invest_id');
            $table->unsignedBigInteger('payment_method');
            $table->unsignedBigInteger('invest_type');
            $table->decimal('amount',19,4,true);
            $table->decimal('discount',19,4,true)->default(0);
            $table->text('sessionID');
            $table->unsignedBigInteger('status')->comment('1:Pending,2:Thành công,3:Thất bại');
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
        Schema::dropIfExists('orders');
    }
}
