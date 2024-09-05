<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active')->default(false);
            $table->string('code');
            $table->integer('percentage');
            $table->integer('discount');
            $table->boolean('is_contributor')->default(false);
            $table->boolean('onetime')->default(false);
            $table->integer('user_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

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
        Schema::dropIfExists('discount_codes');
    }
}
