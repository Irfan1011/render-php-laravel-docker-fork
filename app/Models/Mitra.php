<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table='mitra';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'car_name',
        'car_type',
        'transmission_type',
        'fuel_type',
        'fuel_volume',
        'color',
        'passenger_capasity',
        'facility',
        'license_plate',
        'vehicle_registration_number',
        'asset_category',
        'owner_id',
        'started_contract',
        'ending_contract',
        'latest_day_service',
        'daily_price',
        'status',
    ];
    
    protected $attributes = [
        'adminVerif' => 'Null',
        'daily_price' => 0,
        'status' => 'NULL',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->user_id = auth()->user()->id;
        });
    }
}
