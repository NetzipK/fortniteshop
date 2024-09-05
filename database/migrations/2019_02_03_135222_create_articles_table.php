<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('external_id');

            $table->string('name');
            $table->string('type')->default('default');

            $table->text('description')->nullable();
            $table->boolean('active')->default(false);


            $table->integer('amount_min')->default(1);
            $table->integer('amount_max')->default(1);
            $table->integer('amount_step_size')->default(1);

            $table->boolean('is_sale')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->boolean('available_on_PC')->default(false);
            $table->boolean('available_on_PS4')->default(false);
            $table->boolean('available_on_XBOX')->default(false);

            $table->float('price')->default(5);

            $table->string('item_type')->nullable();
            $table->string('item_perk')->nullable();

            $table->string('image_name')->nullable();

            $table->integer('power_level')->default(0);
            $table->integer('stars')->default(0);

            $table->integer('views')->default(0);
            $table->timestamps();
            $table->string('unique_id');
            $table->string('tags')->nullable();
            $table->float('price_per_one')->default(1);
            $table->integer('priority')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
