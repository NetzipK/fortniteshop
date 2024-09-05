<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skins', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('external_id');

            /* Basic Item Information */
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('tags')->nullable();
            $table->string('image_name')->nullable();
            $table->float('price')->default(5);
            $table->boolean('active')->default(true);
            $table->boolean('is_sold')->default(false);

            /* Skin Related Information */
            $table->boolean('codeSkin')->default(false);
            $table->string('code')->default('ASD123-FGH456-XCV789');
            $table->integer('vbucks')->default(0);
            $table->boolean('available_on_PC')->default(false);
            $table->boolean('available_on_PS4')->default(false);
            $table->boolean('available_on_XBOX')->default(false);
            $table->boolean('available_on_SWITCH')->default(false);
            $table->boolean('acc_needed')->default(false);

            /* Others */
            $table->timestamps();
        });
        DB::update("ALTER TABLE skins AUTO_INCREMENT = 20000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skins');
    }
}
