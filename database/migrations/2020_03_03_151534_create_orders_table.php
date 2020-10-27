<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('order_code');
            $table->integer('service_id');
            $table->string('service_title');
            $table->string('action')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('weight')->nullable();
            $table->float('order_amount');
            $table->float('amount_paid')->nullable();
            $table->integer('codepromo_id')->nullable();
            $table->string('code_promo')->nullable();
            $table->float('discount')->nullable();
            $table->float('taxe')->nullable();
            $table->float('total_net')->nullable();
            $table->float('left_pay')->nullable();
            $table->mediumText('meeting_place')->nullable();
            $table->string('meeting_longitude')->nullable();
            $table->string('meeting_latitude')->nullable();
            $table->mediumText('place_delivery')->nullable();
            $table->string('delivery_longitude')->nullable();
            $table->string('delivery_latitude')->nullable();
            $table->string('delivery_date')->nullable();
            $table->datetime('date_collect')->nullable();
            $table->datetime('date_delivered')->nullable();
            $table->string('identifier')->nullable();
            $table->integer('client_id');
            $table->string('client_name')->nullable();
            $table->string('client_firstname')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->integer('client_userid');
            $table->integer('collector_id')->nullable();
            $table->string('collector_name')->nullable();
            $table->string('collector_firstname')->nullable();
            $table->string('collector_email')->nullable();
            $table->string('collector_address')->nullable();
            $table->string('collector_phone')->nullable();
            $table->string('collector_userid')->nullable();
            $table->integer('status');
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
