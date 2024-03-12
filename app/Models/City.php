<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'city'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'city_id';
    protected $fillable = [
        'il_no',
        'isim'
    ];
  
}
