<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDrive extends Model
{
    use HasFactory;
    protected $table = 'test_drive'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'drive_id';
}
