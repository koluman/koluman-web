<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $table = 'announcements'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'announcement_id';
    protected $fillable = [
        'announcement_id',
        'company_id',
        'announcement_title',
        'announcement_description',
        'announcement_image_url',
        'announcement_state',
        'announcement_date',
        'isActive',
    ];
}
