<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // public function up() {
    //     Schema::create('states', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('state_name');
    //         $table->unsignedInteger('country_id')->index();
    //         $table->string('country_code');
    //         $table->string('fips_code')->nullable();
    //         $table->string('iso2');
    //         $table->string('latitude')->nullable();
    //         $table->string('longitude')->nullable();
    //         $table->boolean('flag')->default(0);
    //         $table->text('wikiDataId')->nullable();
    //         $table->integer('status')->comment('1=Active, 2=Inactive')->default(1);
    //         $table->softDeletes();
    //         $table->timestamps();
    //     });
    // }

    public function down() {
        Schema::dropIfExists('states');
    }
};
