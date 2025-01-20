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
        Schema::create('driver', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->string('photo');
            $table->string('address');
            $table->date('birth');
            $table->string('gender');
            $table->string('phone');
            $table->string('language');
            $table->string('photocopy_scanDriverLicense');
            $table->string('drug_free_letter');
            $table->string('mental_health_letter');
            $table->string('physical_health_certificate');
            $table->string('criminal_record_certificate');
            $table->integer('transaction_total');
            $table->float('rating_avg');
            $table->double('daily_price');
            $table->string('verifikasi_admin');
            $table->string('rental_verif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver');
    }
};
