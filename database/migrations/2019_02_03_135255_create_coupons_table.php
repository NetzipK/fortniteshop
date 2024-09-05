<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->boolean('active')->default(false);
            $table->boolean('is_fixed')->default(false);
            $table->boolean('is_percent')->default(true);
            $table->boolean('is_user_specific')->default(true);
            $table->integer('value')->default(0)->nullable();
            $table->integer('percent_off')->default(5)->nullable();

            $table->integer('times_used')->default(0);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
