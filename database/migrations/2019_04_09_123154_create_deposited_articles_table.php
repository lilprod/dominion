<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositedArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('deposited_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('article_id');
            $table->string('article_title');
            $table->string('designation')->nullable();
            $table->float('unit_price');
            $table->float('amount')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('tidy')->nullable();
            $table->integer('order_id');
            $table->integer('client_id');
            $table->string('client_name');
            $table->string('client_firstname');
            $table->integer('client_userid');
            $table->integer('user_id');
            $table->integer('status');
            $table->string('etat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('deposited_articles');
    }
}
