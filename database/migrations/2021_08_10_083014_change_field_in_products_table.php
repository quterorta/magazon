<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('short_description')->nullable();
            $table->foreignId('specification_id')->constrained()->onDelete('cascade')->nullable();
            $table->float('rating', 3, 1)->nullable();
            $table->foreignId('rewiew_id')->constrained()->onDelete('cascade')->nullable();
            $table->boolean('product_in_sale')->default(0);
            $table->string('new_price')->nullable();
            $table->string('loan_terms')->nullable();
            $table->boolean('recommended')->default(0);
            $table->boolean('popular')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
