<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdviceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advice_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('advice_id');
            $table->tinyInteger('is_completed')->default(0)->comment('1: completed; 0: is_completed');
            $table->string('day');
            $table->integer('hour');
            $table->integer('minute');
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
        Schema::dropIfExists('advice_users');
    }
}
