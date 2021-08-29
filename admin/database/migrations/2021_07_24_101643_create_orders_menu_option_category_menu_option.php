<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersMenuOptionCategoryMenuOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_menu_option_category_menu_option', function (Blueprint $table) {
            $table->integer("order_menu_item_id");
            $table->integer("menu_option_category_menu_option_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_menu_option_category_menu_option');
    }
}
