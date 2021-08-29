<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menu_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('menu_item_id');
            $table->string('price');
            $table->integer('qty');
            $table->string('order_menu_item_')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_menu_items');
    }
}
