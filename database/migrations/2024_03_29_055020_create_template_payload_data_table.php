<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('template_payload_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_name_id');
            $table->json('data');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('template_payload_data');
    }



};
