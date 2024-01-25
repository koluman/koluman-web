<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointment'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'appointment_id',
        'car_id',
        'appointment_time',
        'appointment_date',
        'user_id',
        'state',
        'created_at',
        'updated_at'
    ];
    public function car()
    {
        return $this->belongsTo(Showroom::class, 'car_id');
    }
}
