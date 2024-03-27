<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder {
    public function run() {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            array(
                'name' => 'Kajal Kumari',
                'email' => 'kajal01@gmail.com',
                'password' => Hash::make('archana'),
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(,
                'name' => 'Sadaf Fatima',
                'email' => 'sadaf01@gmail.com',
                'password' => Hash::make('sadaf'),
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'name' => 'Zoya Ahmed',
                'email' => 'zoya01@gmail.com',
                'password' => Hash::make('zoya'),
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ]);
    }
}
