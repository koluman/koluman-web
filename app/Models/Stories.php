<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;
    protected $table = 'stories'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'story_id';
    protected $fillable = [
        'story_id',
        'company_id',
        'story_title',
        'story_small_image',
        'story_big_image',
        'story_priority',
        'story_state',
        'created_at',
        'updated_at'
    ];
  
}
