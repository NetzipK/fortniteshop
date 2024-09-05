<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {

            $table->increments('id');
            $table->uuid('external_id');

            /* Basic Item Information */
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('tags')->nullable();
            $table->string('image_name')->nullable();
            $table->float('price')->default(5);
            $table->boolean('active')->default(false);
            $table->boolean('is_sold')->default(false);

            $table->boolean('is_popular')->default(false);
            $table->boolean('is_sale')->default(false);
            $table->boolean('is_featured')->default(false);

            /* Account Related Information */
            $table->string('username')->default('username');
            $table->string('password')->default('password');
            $table->boolean('full_access')->default(false);
            $table->integer('vbucks')->default(0);
            $table->integer('account_level')->default(1);
            $table->boolean('available_on_PC')->default(false);
            $table->boolean('available_on_PS4')->default(false);
            $table->boolean('available_on_XBOX')->default(false);
            $table->boolean('available_on_SWITCH')->default(false);
            $table->boolean('pve')->default(true);

            /* PVP Related Information */
            $table->boolean('battle_pass')->default(false);
            $table->integer('battle_pass_level')->default(1);
            $table->integer('outfits')->default(0);
            $table->integer('back_bling')->default(0);
            $table->integer('pickaxes')->default(0);
            $table->integer('gliders')->default(0);
            $table->integer('dances')->default(0);

            /* PVE Related Information */
            $table->integer('homebase_level')->default(1);
            $table->string('campagne')->nullable();
            $table->boolean('standard_edition')->default(true);
            $table->boolean('deluxe_edition')->default(false);
            $table->boolean('super_deluxe_edition')->default(false);

            /* Others */
            $table->timestamps();
        });
        DB::update("ALTER TABLE accounts AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
