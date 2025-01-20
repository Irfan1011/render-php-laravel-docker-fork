<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table='driver';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'photo',
        'address',
        'birth',
        'gender',
        'phone',
        'language',
        'photocopy_scanDriverLicense',
        'drug_free_letter',
        'mental_health_letter',
        'physical_health_certificate',
        'criminal_record_certificate',
        'transaction_total',
        'daily_price',
        'rental_verif',
    ];
    protected $attributes = [
        'transaction_total' => 0,
        'rating_avg' => 0,
        'verifikasi_admin' => 'NULL',
        'daily_price' => 0,
        'rental_verif' => 'NULL',
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->user_id = auth()->user()->id;
        });
    }
    public function setBahasaAttribute($value)
    {
        $this->attributes['bahasa'] = json_encode($value);
    }

    public function getBahasaAttribute($value)
    {
        return $this->attributes['bahasa'] = json_decode($value);
    }
    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class);
    // }
}