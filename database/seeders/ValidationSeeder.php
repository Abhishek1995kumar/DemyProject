<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ValidationSeeder extends Seeder {
    public function run() {
        DB::table('validations')->truncate();
        DB::table('validations')->insert([
            array(
                "validation_name" => "string",
                "validation_name_show" => "string type validation",
                "validation_type" => 'string|sometimes|required',
                "is_mandatory" => 1,
                'comments' => 'The field data must have string character in the database table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "unique",
                "validation_name_show" => "unique type validation",
                "validation_type" => 'sometimes',
                "is_mandatory" => 2,
                'comments' => 'The field data must not have unique in the database table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "email",
                "validation_name_show" => "email type validation",
                "validation_type" => 'sometimes|required|email',
                "is_mandatory" => 1,
                'comments' => 'The field data must be a valid email address',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "bail",
                "validation_name_show" => "bail type validation",
                "validation_type" => 'sometimes|required',
                "is_mandatory" => 1,
                'comments' => 'The validation rule stops executing after it encounters its first validation failure',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "array",
                "validation_name_show" => "array type validation",
                "validation_type" => 'sometimes|required',
                "is_mandatory" => 1,
                'comments' => 'The field data must be a PHP array',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "numeric",
                "validation_name_show" => "numeric type validation",
                "validation_type" => 'numeric',
                "is_mandatory" => 2,
                'comments' => 'The field data must be a numeric in the database table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "min",
                "validation_name_show" => "min type validation",
                "validation_type" => 'min:5',
                "is_mandatory" => 2,
                'comments' => 'The field data must be a minimun value in the database table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "max",
                "validation_name_show" => "max type validation",
                "validation_type" => 'max:255',
                "is_mandatory" => 2,
                'comments' => 'The field data must be a maximum value in the database table',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "alpha_num",
                "validation_name_show" => "alpha numeric type validation",
                "validation_type" => 'required|regex:/([a-zA-Z]{1,10})([0-9]{1,10})/',
                "is_mandatory" => 1,
                'comments' => '([a-zA-Z]{1,10})([0-9]{1,10}) - atleast one alphabate and after atleast one numeric character accepted',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
            array(
                "validation_name" => "image",
                "validation_name_show" => "image type validation",
                "validation_type" => 'mimes:jpeg,jpg,bmp,png',
                "is_mandatory" => 2,
                'comments' => '([a-zA-Z]{1,10})([0-9]{1,10}) - atleast one alphabate and after atleast one numeric character accepted',
                "status" => 1,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => NULL,
            ),
        ]);
    }
}
