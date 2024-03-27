<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder {
    public function run() {
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            array(
                'name' => 'Kajal',
                'lname' => 'Kumari',
                'username' => 'Kajal Kumari',
                'phone' => '9415058209',
                'email' => 'archana01@gmail.com',
                'password' => Hash::make('archana'),
                'default_password' => 'archana',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'name' => 'Sadaf',
                'lname' => 'Fatima',
                'username' => 'Sadaf Fatima',
                'phone' => '9415058209',
                'email' => 'sadaf01@gmail.com',
                'password' => Hash::make('sadaf'),
                'default_password' => 'sadaf',
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'name' => 'Zoya',
                'lname' => 'Ahmed',
                'username' => 'Zoya Ahmed',
                'phone' => '9415058209',
                'email' => 'zoya01@gmail.com',
                'password' => Hash::make('zoya'),
                'default_password' => 'zoya',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ]);
    }
}
