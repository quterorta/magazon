<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=1; $i < 6; $i++)
            DB::table('categories')->insert([
                'title' => 'Category '.$i,
                'image' => '/category-image/category-'.$i.'.jpg',
                'alias' => 'category-'.$i,
            ]);
    }
}
