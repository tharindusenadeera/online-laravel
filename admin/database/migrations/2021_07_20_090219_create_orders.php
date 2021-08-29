<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('billing_address_1')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('delivery_address_line_1')->nullable();
            $table->string('delivery_address_line_2')->nullable();
            $table->integer('status')->default(1);
            $table->string('discount_type')->nullable();
            $table->integer('discount_value')->nullable();
            $table->string('tracking_code')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('kitchen_user_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('delivery_city_id')->nullable();
            $table->integer('billing_city_id')->nullable();
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
