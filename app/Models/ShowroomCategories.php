<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomCategories extends Model
{
    use HasFactory;
    protected $table = 'showroom_categories'; 
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'company_id',
        'category_name',
        'category_img_url',
        'created_at',
        'updated_at'
    ];
   
}
