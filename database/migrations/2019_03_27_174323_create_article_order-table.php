<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_order', function (Blueprint $table) {
            $table->bigIncrements('id');

            /** Relations */
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')
                  ->on('articles');
            $table->integer('article_id')->unsigned()->nullable();
            $table->foreign('article_id')->references('id')
                ->on('articles');

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
        Schema::dropIfExists('article_order');
    }
}