<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuOptionCategoryMenuOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_option_category_menu_option', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_option_category_id');
            $table->integer('menu_option_id');
            $table->string('status');

            // $table->foreign('menu_option_category_id')->references('id')->on('menu_option_category');
            // $table->foreign('menu_option_id')->references('id')->on('menu_option');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_option_category_menu_option');
    }
}
