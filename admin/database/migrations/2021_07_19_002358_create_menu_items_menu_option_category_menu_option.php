<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsMenuOptionCategoryMenuOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items_menu_option_category_menu_option', function (Blueprint $table) {
            $table->integer('menu_item_id');
            $table->integer('menu_option_category_menu_option_id');

            // $table->foreign('menu_item_id')->references('id')->on('menu_item');
            // $table->foreign('menu_option_category_menu_option_id','fk_cat_id')->references('id')->on('menu_option_category_menu_option');
    
            // $table->primary(['menu_item_id', 'menu_option_category_menu_option_id'],'custom_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items_menu_option_category_menu_option');
    }
}
