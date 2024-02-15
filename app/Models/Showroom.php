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
        'car_type',
        'step1',
        'step2',
        'step3',
        'step4',
        'step5',
        'car_name',
        'company_id',
        'car_description',
        'car_image_url',
        'isTestdrive',
        'created_at',
        'updated_at'
    ];
    public function cars()
    {
        return $this->hasMany(Companies::class, 'company_id', 'company_id');
    }
}
