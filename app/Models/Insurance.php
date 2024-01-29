<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    protected $table = 'insurance'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'insurance_id';
    protected $fillable = [
        'insurance_id',
        'user_id',
        'insurance_type',
        'insurance_policy_url',
        'insurance_request_date',
        'insurance_review_date',
        'insurance_result_date',
        'insurance_end_date',
        'insurance_price',
        'insurance_description',
        'insurance_state',
        'insurance_author',
        'created_at', 'updated_at'
    ];
}
