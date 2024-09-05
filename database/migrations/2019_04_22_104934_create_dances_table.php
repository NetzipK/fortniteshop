<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('image_name')->nullable();
            $table->timestamps();
        });

        Schema::create('account_dance', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->integer('dance_id')->unsigned()->index();
            $table->foreign('dance_id')->references('id')->on('dances')->onDelete('cascade');

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
        Schema::dropIfExists('account_dance');
        Schema::dropIfExists('dances');
    }
}
