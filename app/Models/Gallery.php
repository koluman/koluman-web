<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'showroom_gallery'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'gallery_id';
    protected $fillable = [
        'gallery_id',
        'car_id',
        'car_img_url',
        'car_img_type',
        'created_at',
        'updated_at'
    ];
 
}
