<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNitritionalInforTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nitritional_infor', function (Blueprint $table) {
            $table->id();
            $table->integer('advice_id');
            $table->string('name');
            $table->string('portion');
            $table->string('calories');
            $table->string('fat');
            $table->string('carbohydrate');
            $table->string('protein');
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
        Schema::dropIfExists('nitritional_infor');
    }
}
