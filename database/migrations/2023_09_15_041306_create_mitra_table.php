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
    public function up()
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('car_name');
            $table->string('car_type');
            $table->string('transmission_type');
            $table->string('fuel_type');
            $table->integer('fuel_volume');
            $table->string('color');
            $table->integer('passenger_capasity');
            $table->string('facility');
            $table->string('license_plate');
            $table->string('vehicle_registration_number');
            $table->string('asset_category');
            $table->string('owner_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('started_contract');
            $table->date('ending_contract');
            $table->date('latest_day_service');
            $table->string('adminVerif');
            $table->string('status');
            $table->double('daily_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra');
    }
};
