<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DataTypeSeeder extends Seeder {
    public function run() {
        DB::table('data_types')->truncate();
        DB::table('data_types')->insert([
            array(
                "data_type_name" => "string data type",
                "data_type_value" => "string",
                'comments' => 'String equivalent to the table, please select atleast 2 characters ([a-zA-Z_]{2,})',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            // array(
            //     "data_type_name" => "alpha_num data type",
            //     "data_type_value" => "([a-zA-Z_]{2,})([0-9]{1,})",
            //     'comments' => 'Alpha numeric equivalent to the table, please select atleast 2 characters and after atleast 1 number',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "decimal data type",
            //     "data_type_value" => "decimal",
            //     'comments' => 'array equivalent to the table, please select array',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "enum data type",
            //     "data_type_value" => "enum",
            //     'comments' => 'enum equivalent to the table',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "email data type ([a-zA-Z_]{2,})([0-9]{0,})([@]{1})([a-z]{3,})([.]{1})([a-z]{2,20})",
            //     "data_type_value" => "email",
            //     'comments' => 'email equivalent to the table, please select atleast 2 character string after select number or null after select 1 @ after select 3 character string  select special characters after select 1 . after select 3 character string  ',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "binary data type",
            //     "data_type_value" => "binary",
            //     'comments' => 'binary type corresponding to one of the listed extensions',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "datetime data type",
            //     "data_type_value" => "datetime",
            //     'comments' => 'min equivalent to the table',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "longText data type",
            //     "data_type_value" => "longText",
            //     'comments' => 'Long Text equivalent to the table like array',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            array(
                "data_type_name" => "integer data type",
                "data_type_value" => "integer",
                'comments' => 'integer equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "Array data type",
                "data_type_value" => "array",
                'comments' => 'float equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            // array(
            //     "data_type_name" => "float data type",
            //     "data_type_value" => "float",
            //     'comments' => 'float equivalent to the table',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            // array(
            //     "data_type_name" => "boolean data type",
            //     "data_type_value" => "boolean",
            //     'comments' => 'Boolean equivalent to the table',
            //     "status" => 1,
            //     "created_at" => now(),
            //     "updated_at" => now(),
            //     "deleted_at" => NULL,
            // ),
            array(
                "data_type_name" => "timestamp data type",
                "data_type_value" => "timestamp",
                'comments' => 'timestamp equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
        ]);
    }
}
