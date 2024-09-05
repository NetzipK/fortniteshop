<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkinOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skin_order', function (Blueprint $table) {
            $table->increments('id');

            /** Relations */
            $table->integer('skin_id')->unsigned()->index();
            $table->foreign('skin_id')->references('id')->on('skins')->onDelete('cascade');
            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            /** Additional fields */
            $table->integer('quantity')->unsigned();
            $table->float('price_per_unit')->unsigned();
            $table->float('subtotal')->unsigned();
            $table->string('name');
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
        Schema::dropIfExists('skin_order');
    }
}
