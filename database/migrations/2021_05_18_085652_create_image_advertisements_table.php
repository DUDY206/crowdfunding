<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_advertisements', function (Blueprint $table) {
            $table->id();
            $table->text('img')->nullable();
            $table->text('url')->nullable();
            $table->unsignedSmallInteger('sort_level')->comment('1: level 1, 2: level 2,3 level 3,4 level 4,5 level 5')->default(1);
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
        Schema::dropIfExists('image_advertisements');
    }
}
