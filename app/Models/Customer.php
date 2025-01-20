<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\passport\HasApiTokens;

class Customer extends Model
{
    protected $table='customer';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'address',
        'birth',
        'gender',
        'phone',
    ];
    protected $attributes = [
        'verifikasi_CS' => 'NULL',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->user_id = auth()->user()->id;
        });
    }
    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
}