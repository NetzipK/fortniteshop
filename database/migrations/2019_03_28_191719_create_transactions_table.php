<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_type')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('invoice')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('address_status')->nullable();
            $table->string('payer_status')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('address_name')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_street')->nullable();
            $table->string('business')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('mc_currency')->nullable();
            $table->string('mc_fee')->nullable();
            $table->string('mc_handling')->nullable();
            $table->string('mc_shipping')->nullable();
            $table->string('txn_type')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('notify_version')->nullable();
            $table->string('verify_sign')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
