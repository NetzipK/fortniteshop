<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            /** Order identifier */
            $table->increments('id');
            $table->uuid('invoice_number');
            $table->string('invoice_description');

            /** General user information */
            $table->string('email');
            $table->string('epic_id');
            $table->string('discord_id')->nullable();
            $table->string('order_password');
            $table->string('platform');
            $table->string('platform_username')->nullable();


            /** General order information */
            $table->string('payment_gateway')->default('paypal');

            /** Order price */
            $table->float('subtotal')->default(0);
            $table->float('discount')->default(0);
            $table->float('total');

            /** Order status */
            $table->boolean('order_paid')->default(false);
            $table->boolean('order_failed')->default(false);
            $table->boolean('order_refunded')->default(false);

            /** Order delivery */
            $table->boolean('order_delievered')->default(false);
            $table->string('order_delievered_by')->nullable();
            $table->dateTime('order_delievered_at')->nullable();

            /** Paypal token */
            $table->string('paypal_token');

            /** Timestamps */
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
        Schema::dropIfExists('orders');
    }
}
