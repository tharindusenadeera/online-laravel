<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('main_image');
            $table->double('price');
            $table->integer('qty');
            $table->integer('status');
            $table->integer('created_by');
            $table->integer('menu_category');
            $table->timestamps();

            // $table->foreign('menu_category')->references('id')->on('menu_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_item');
    }
}
