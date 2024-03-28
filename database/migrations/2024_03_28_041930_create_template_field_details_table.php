<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('template_field_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('validation_id')->comment('Validation table id');
            $table->unsignedBigInteger('data_type_id')->comment('Data type table id');
            $table->unsignedBigInteger('template_name_id')->comment('Template Name table id');

            $table->string('admin_name')->comment('Admin name')->nullable();
            $table->string('admin_code')->comment('Admin code')->nullable();
            $table->string('admin_email')->comment('Admin email')->nullable();
            $table->string('admin_contact')->comment('Admin contact')->nullable();
            $table->string('admin_address')->comment('Admin address')->nullable();
            $table->string('admin_department_name')->comment('Admin department name')->nullable();
            $table->string('admin_reporting_manager')->comment('Admin reporting manager')->nullable();
            $table->string('admin_role')->comment('Admin role')->nullable();

            $table->string('employee_fname')->comment('Employee first name')->nullable();
            $table->string('employee_lname')->comment('Employee last name')->nullable();
            $table->string('employee_code')->comment('Employee Code')->nullable();
            $table->string('employee_contact')->comment('Employee contact')->nullable();
            $table->string('employee_department')->comment('Employee department')->nullable();
            $table->string('employee_dob')->comment('Employee date of birth')->nullable();
            $table->string('employee_doj')->comment('Employee date of joinning')->nullable();
            $table->string('employee_salary')->comment('Employee salary')->nullable();
            $table->string('employee_email')->comment('Employee email')->nullable();
            $table->string('employee_address')->comment('Employee address')->nullable();
            $table->string('employee_acc_no')->comment('Employee account number')->nullable();
            $table->string('employee_ifsc_code')->comment('Employee ifsc code')->nullable();
            $table->string('employee_aadhar_card')->comment('Employee aadhar card')->nullable();
            $table->string('employee_experience_level')->comment('Employee experience level')->nullable();
            $table->string('employee_department_name')->comment('Employee department name')->nullable();

            $table->string('orgnization_name')->comment('Orgnization name')->nullable();
            $table->string('orgnization_code')->comment('Orgnization code')->nullable();
            $table->string('orgnization_contact')->comment('Orgnization contact')->nullable();
            $table->string('orgnization_email')->comment('Orgnization email')->nullable();
            $table->string('orgnization_address')->comment('Orgnization address')->nullable();
            $table->string('orgnization_department_name')->comment('Orgnization department name')->nullable();

            $table->string('vendor_name')->comment('Vendor name')->nullable();
            $table->string('vendor_shop_name')->comment('Vendor shop name')->nullable();
            $table->string('vendor_contact')->comment('Vendor contact')->nullable();
            $table->string('vendor_email')->comment('Vendor email')->nullable();
            $table->string('vendor_address')->comment('Vendor address')->nullable();
            $table->string('vendor_landmark')->comment('Vendor landmark')->nullable();
            $table->string('vendor_address_proof')->comment('Vendor address proof')->nullable();
            $table->string('vendor_fax')->comment('Vendor fax')->nullable();

            $table->tinyInteger('status')->comment('1=Success, 2=Unsuccess')->default(2);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }


    public function down() {
        Schema::dropIfExists('template_field_details');
    }


};
