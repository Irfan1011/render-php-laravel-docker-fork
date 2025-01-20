<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table='car';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'photo',
        'type',
        'transmission_type',
        'fuel_type',
        'color',
        'trunk_volume',
        'facility',
        'daily_price',
        'status',
        'license_plate',
    ];
    protected $attributes = [
        'license_plate' => 'NULL',
    ];
    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
    // public function detail_mobil()
    // {
    //     return $this->hasMany(DetailMobil::class);
    // }
}
