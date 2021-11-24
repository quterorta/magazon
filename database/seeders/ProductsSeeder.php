<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=1; $i < 20; $i++)
            DB::table('products')->insert([
                'title' => 'Product '.$i,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'active' => 1,
                'price' => rand(150, 2000),
                'category_id' => rand(1, 5),
                'alias' => 'product-'.$i,
            ]);
    }
}
