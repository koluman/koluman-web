<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;
    protected $table = 'companies'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'company_id';
    protected $fillable = [
        'company_id',
        'company_name',
        'company_image_url',
        'created_at',
        'updated_at'
    ];
    public function showrooms()
    {
        return $this->hasMany(Showroom::class, 'company_id', 'company_id');
    }
}
