<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->tinyInteger('sex')->comment('1: male; 2: female')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('weight')->nullable();
            $table->tinyInteger('unit_weight')->comment('1: kg; 2: lbs')->nullable();
            $table->integer('height')->nullable();
            $table->tinyInteger('unit_height')->comment('1: cm; 2: ft & inch')->nullable();
            $table->tinyInteger('alcohol_consumption')->nullable();
            $table->tinyInteger('cigarette')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active; 0: inactive');
            $table->string('code')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
