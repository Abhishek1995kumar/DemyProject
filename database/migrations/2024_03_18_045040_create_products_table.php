<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('dimension_id');
            $table->unsignedBigInteger('stock_id');
            $table->string('product_title')->nullable();
            $table->string('product_sku')->unique();
            $table->string('entry_by')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('warrenty_type')->nullable();
            $table->string('product_manufracturer')->nullable();
            $table->string('product_description')->nullable();
            $table->integer('product_quantity')->nullable();
            $table->string('usagesduration')->nullable();
            $table->string('product_notes')->nullable();
            $table->string('product_discount')->nullable();
            $table->string('product_material')->nullable();
            $table->integer('product_price');
            $table->string('product_city_name');
            $table->string('product_state_name');
            $table->string('product_country_name');
            $table->tinyInteger('status')->comment('1=Product Not Available, 2=Product Available')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
