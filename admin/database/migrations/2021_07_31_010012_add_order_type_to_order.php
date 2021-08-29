<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderTypeToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            
            $table->string('delivery_first_name')->nullable()->after('billing_address_2');
            $table->string('delivery_last_name')->nullable()->after('delivery_first_name');
            $table->string('delivery_phone_number')->nullable()->after('delivery_address_line_2');
            $table->string('order_type')->after('tracking_code');
            $table->integer('total')->after('order_type');
        });
    }    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_type');
        });
    }
}
