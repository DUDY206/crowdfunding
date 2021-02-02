<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInvestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('name');
            $table->unsignedBigInteger('slug')->nullable();
            $table->unsignedBigInteger('short_description')->nullable();
            $table->text('img_url')->nullable();
            $table->text('video_url')->nullable();
            $table->decimal('min_invest',19,4,true);
            $table->decimal('valuation_cap',19,4,true);
            $table->unsignedBigInteger('location')->nullable();
            $table->unsignedSmallInteger('status')->comment('1:Đang gọi vốn,2: Đã gọi vốn xong, 3: Giải thể')->default(1);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('total_follow')->nullable();

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
        Schema::dropIfExists('company_investments');
    }
}
