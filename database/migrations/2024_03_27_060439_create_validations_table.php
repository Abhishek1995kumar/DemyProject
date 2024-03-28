<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->string('validation_name')->nullable();
            $table->string('validation_name_show')->nullable();
            $table->string('validation_type')->nullable();
            $table->longText('comments')->nullable();
            $table->tinyInteger('is_mandatory')->default(1)->comment('1=Mandatory, 2=Not Mandatory');
            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Not Active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('validations');
    }
};
