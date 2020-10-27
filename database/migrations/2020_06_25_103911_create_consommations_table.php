<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsommationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consommations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('savon_poudre')->nullable();
            $table->float('javel')->nullable();
            $table->float('eau_parfumee')->nullable();
            $table->float('eau')->nullable();
            $table->float('savon_liquide')->nullable();
            $table->float('courant')->nullable();
            $table->float('goma')->nullable();
            $table->float('visseline')->nullable();
            $table->float('agrafe')->nullable();
            $table->float('lingette')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('order_qty')->nullable();
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
        Schema::dropIfExists('consommations');
    }
}
