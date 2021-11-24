<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoFieldsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('last_name')->after('user_id');
            $table->string('email')->after('name');
            $table->dropColumn(['country_shipment', 'region_shipment', 'city_shipment']);
            $table->foreignId('country_id')->constrained()->onDelete('cascade')->after('phone');
            $table->foreignId('region_id')->constrained()->onDelete('cascade')->after('country_id');
            $table->foreignId('city_id')->constrained()->onDelete('cascade')->after('region_id');
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
            //
        });
    }
}
