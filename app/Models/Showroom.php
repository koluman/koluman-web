<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory;
    protected $table = 'showroom'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'car_id';
    protected $fillable = [
        'car_id',
        'car_name',
        'car_image_url',
        'auto_date',
    ];
}
