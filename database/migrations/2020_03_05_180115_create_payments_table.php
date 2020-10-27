<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->string('client_name')->nullable();
            $table->string('client_firstname')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->integer('client_userid');
            $table->integer('paymentmode_id')->nullable();
            $table->string('paymentmode_title')->nullable();
            $table->string('tx_reference')->nullable();
            $table->string('identifier')->nullable();
            $table->string('payment_reference')->nullable();
            $table->dateTime('date_payment')->nullable();
            $table->string('telephone')->nullable();
            $table->integer('status');
            $table->integer('order_id');
            $table->string('order_code');
            $table->string('order_service');
            $table->string('description')->nullable();
            $table->float('order_amount');
            $table->integer('collector_id')->nullable();
            $table->string('collector_name')->nullable();
            $table->string('collector_firstname')->nullable();
            $table->string('collector_email')->nullable();
            $table->string('collector_address')->nullable();
            $table->string('collector_phone')->nullable();
            $table->integer('collector_userid');
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
        Schema::dropIfExists('payments');
    }
}
