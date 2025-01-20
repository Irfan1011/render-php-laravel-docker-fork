<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table='shift';
    protected $primarykey='id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'shift_time',
        'day',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}