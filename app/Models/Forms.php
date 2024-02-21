<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;
    protected $table = 'forms'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'type',
        'firstname',
        'lastname',
        'phone',
        'email',
        'city',
        'message',
        'insurance_type',
        'created_at',
        'updated_at'
    ];
}
