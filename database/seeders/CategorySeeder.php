<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder {
    public function run() {
        DB::table('categories')->truncate();
        DB::table('categories')->insert([
            array(
                'category_name' => 'Laptops',
                'category_slug' => 'Laptops101',
                'tax' => 12,
                'roles' => 1,
                'category_image' => 'public/image/Dell_logo_2016.svg.webp',
                'created_at' => now(),
                'updated_at' => now(),    
            ),
            array(
                'category_name' => 'Mobiles',
                'category_slug' => 'Mobiles102',
                'tax' => 18,
                'roles' => 1,
                'category_image' => 'public/image/Dell_logo_2016.svg.webp',
                'created_at' => now(),
                'updated_at' => now(),    
            ),
        ]);
    }
}
