<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table='promo';
    protected $primarykey='promo_code';
    public $timestamps = true;
    protected $fillable = [
        'promo_code',
        'promo_type',
        'discount',
        'description',
    ];
    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
}