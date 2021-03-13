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
            $table->unsignedBigInteger('invest_type_id');
            $table->text('contract_url');
            $table->text('signature')->nullable();
            $table->decimal('amount',19,4,true);
            $table->unsignedBigInteger('payment_method')->comment('1:Offline,2:VNPay')->nullable();
            $table->unsignedBigInteger('payment_status')->comment('1:Khởi tạo,2:Thanh toán,3:Xác nhận');
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
