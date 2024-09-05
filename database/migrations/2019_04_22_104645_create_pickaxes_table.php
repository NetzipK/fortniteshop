<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickaxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->string('image_name')->nullable();
            $table->timestamps();
        });

        Schema::create('account_pickaxe', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->integer('pickaxe_id')->unsigned()->index();
            $table->foreign('pickaxe_id')->references('id')->on('pickaxes')->onDelete('cascade');

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
        Schema::dropIfExists('account_pickaxe');
        Schema::dropIfExists('pickaxes');
    }
}
