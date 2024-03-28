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
                "data_type_name" => "string",
                "data_type_name_show" => "string type validation",
                'comments' => 'String equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "numeric",
                "data_type_name_show" => "numeric data type",
                'comments' => 'Numeric equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "binary",
                "data_type_name_show" => "binary data type",
                'comments' => 'BLOB equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "dateTime",
                "data_type_name_show" => "dateTime data type",
                'comments' => 'dateTime equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "decimal",
                "data_type_name_show" => "decimal data type",
                'comments' => 'Decimal equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "double",
                "data_type_name_show" => "double data type",
                'comments' => 'DOUBLE equivalent with precision, 15 digits in total and 8 after the decimal point',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "float",
                "data_type_name_show" => "float data type",
                'comments' => 'Float equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "longText",
                "data_type_name_show" => "longText data type",
                'comments' => 'Long Text equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "softDeletes",
                "data_type_name_show" => "softDeletes data type",
                'comments' => 'Soft Deletes equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "time",
                "data_type_name_show" => "time data type",
                'comments' => 'Time equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "file",
                "data_type_name_show" => "file data type",
                'comments' => 'File equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "data_type_name" => "boolean",
                "data_type_name_show" => "boolean data type",
                'comments' => 'Boolean equivalent to the table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
        ]);
    }
}
