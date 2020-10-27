<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('body');
            $table->integer('client_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_firstname')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->integer('client_userid')->nullable();
            $table->integer('collector_id')->nullable();
            $table->string('user_id');
            $table->string('user_name')->nullable();
            $table->string('user_firstname')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_address')->nullable();
            $table->string('user_phone')->nullable();
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
        Schema::dropIfExists('comments');
    }
}
