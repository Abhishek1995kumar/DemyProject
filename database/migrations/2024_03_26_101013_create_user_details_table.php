<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('type_id');
            $table->string('email');
            $table->string('phone');
            $table->tinyInteger('status')->comment('0=Inactive, 1=Active')->default(1);
            $table->tinyInteger('is_processed')->comment('0=Not processed, 1=Processed')->default(1);
            $table->tinyInteger('has_errors')->comment('0=Not mandatory, 1=Mandatory')->default(1);
            $table->longText('errors')->nullable();
            $table->tinyInteger('is_validated')->comment('0=Data not Validated, 1=Data Validated')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
