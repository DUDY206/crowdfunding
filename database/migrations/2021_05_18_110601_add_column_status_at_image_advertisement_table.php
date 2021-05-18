<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusAtImageAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_advertisements', function (Blueprint $table) {
            $table->unsignedBigInteger('status')->after('sort_level')->comment('0: Hiển thị, 1: Ẩn')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image_advertisements', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
