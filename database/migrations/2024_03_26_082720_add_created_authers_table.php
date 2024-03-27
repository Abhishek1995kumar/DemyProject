<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('authers', function (Blueprint $table) {
            $table->string('created');
        });
    }

    
    public function down() {
        Schema::table('authers', function (Blueprint $table) {
            Schema::dropIfExists('authers');
        });
    }
};
