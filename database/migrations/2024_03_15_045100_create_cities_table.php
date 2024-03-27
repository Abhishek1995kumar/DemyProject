<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // public function up() {
    //     Schema::create('cities', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('city_name');
    //         $table->unsignedBigInteger('country_id');
    //         $table->string('country_code');
    //         $table->unsignedBigInteger('state_id');
    //         $table->string('state_code');
    //         $table->string('latitude');
    //         $table->string('longitude');
    //         $table->integer('flag');
    //         $table->string('wikiDataId');
    //         $table->integer('status')->comment('1=Active, 2=Inactive')->default(1);
    //         $table->softDeletes();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('cities');
    // }
};
