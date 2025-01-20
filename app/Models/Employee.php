<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table='employee';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'photo',
        'address',
        'birth',
        'gender',
        'phone',
        'user_id',
    ];
    protected $attributes = [
        'verifikasi_admin' => 'NULL',
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
    public function shift()
    {
        return $this->hasMany(Shift::class);
    }
}