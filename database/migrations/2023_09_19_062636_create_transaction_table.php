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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('user_id')->on('customer');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('user_id')->on('driver')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('user_id')->on('employee')->nullable();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id')->references('id')->on('car')->nullable();
            $table->unsignedBigInteger('mitra_id')->nullable();
            $table->foreign('mitra_id')->references('id')->on('mitra')->nullable();
            $table->string('promo_code')->nullable();
            $table->foreign('promo_code')->references('promo_code')->on('promo')->nullable();
            $table->string('customer_IDCard');
            $table->string('customer_license');
            $table->date('transaction_date');
            $table->dateTime('date_and_time_transaction_started');
            $table->dateTime('date_and_time_transaction_end');
            $table->dateTime('date_return')->nullable();
            $table->string('payment_method');
            $table->double('car_rental_costs');
            $table->double('driver_costs');
            $table->double('loan_extension');
            $table->double('payment_total');
            $table->string('isDriver');
            $table->string('CS_Verif');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
};
