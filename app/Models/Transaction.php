<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='transaction';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'customer_id',
        'driver_id',
        'employee_id',
        'car_id',
        'mitra_id',
        'promo_code',
        'customer_IDCard',
        'customer_license',
        'transaction_date',
        'date_and_time_transaction_started',
        'date_and_time_transaction_end',
        'date_return',
        'payment_method',
        'car_rental_costs',
        'driver_costs',
        'loan_extension',
        'payment_total',
        'isDriver',
        'CS_Verif',
        'status',
    ];
    protected $attributes = [
        'CS_Verif' => 'NULL',
        'status' => 'NULL',
    ];
}
