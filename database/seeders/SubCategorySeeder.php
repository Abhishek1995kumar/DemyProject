<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SubCategorySeeder extends Seeder {
    public function run() {
        DB::table('sub_categories')->truncate();
        DB::table('sub_categories')->insert([
            array(
                'category_id' => 1,
                'sub_category_name' => 'Dell',
                'sub_category_slug' => 'Dell 5590',
                'sub_category_image' => 'public/image/Dell_logo_2016.svg.webp',
                'created_at' => now(),
                'updated_at' => now(),            
            ),
            array(
                'category_id' => 1,
                'sub_category_name' => 'Dell',
                'sub_category_slug' => 'Dell 5500',
                'sub_category_image' => 'public/image/Dell_logo_2016.svg.webp',
                'created_at' => now(),
                'updated_at' => now(),            
            ),
            array(
                'category_id' => 1,
                'sub_category_name' => 'Dell',
                'sub_category_slug' => 'Dell 3400',
                'sub_category_image' => 'public/image/Dell_logo_2016.svg.webp',
                'created_at' => now(),
                'updated_at' => now(),            
            ),
        ]);
    }
}
