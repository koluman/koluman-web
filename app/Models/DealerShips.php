<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerShips extends Model
{
    use HasFactory;
    protected $table = 'dealerships'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'dealership_id';
    protected $fillable = [
        'dealership_id',
        'company_id',
        'dealership_name',
        'dealership_city', 
        'dealership_address', 
        'dealership_latitude', 
        'dealership_longitude', 
        'dealership_phone', 
        'dealership_description', 
        'dealership_image_url', 
        'created_at', 
        'updated_at'
    ];
}
