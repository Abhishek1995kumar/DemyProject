<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('data_types', function (Blueprint $table) {
            $table->id();
            $table->string('data_type_name')->nullable();
            $table->string('data_type_name_show')->nullable();
            $table->longText('comments')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=Active, 2=Not Active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('data_types');
    }
};
