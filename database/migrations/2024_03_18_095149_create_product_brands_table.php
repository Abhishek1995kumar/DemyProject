<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up() {
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->longText('description');
            $table->tinyInteger('is_enabled')->default(1)->comment('1=enabled, 2=disabled');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down() {
        Schema::dropIfExists('product_brands');
    }
};
