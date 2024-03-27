<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PostSeeder extends Seeder {
    public function run() {
        DB::table('posts')->truncate();
        DB::table('posts')->insert([
            array(
                'user_id'  => 1,
                'title'    => 'Strength',
                'content'  => "This should be long but i don't know what to write, so i'm gonna keep it short like that",
                'created_at'=> now(),
                'updated_at'=> now(),
            ),
            array(
                'user_id'  => 1,
                'title'    => 'Power',
                'content'  => "I don't know what to write, so i'm gonna keep it short like that",
                'created_at'=> now(),
                'updated_at'=> now(),
            ),
            array(
                'user_id'  => 1,
                'title'    => 'Weekness',
                'content'  => "This should be long but i don't know what to write",
                'created_at'=> now(),
                'updated_at'=> now(),
            ),
            array(
                'user_id'  => 2,
                'title'    => 'Strength',
                'content'  => "Well, I wrote same funny stuff in the last post, I gusse you like",
                'created_at'=> now(),
                'updated_at'=> now(),
            ),
        ]);
    }
}
