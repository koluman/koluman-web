<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'id'; // user_id alanını primary key olarak belirtin
    protected $fillable = [
        'id',
        'user_id',
        'user_mail',
        'user_name',
        'user_password',
        'user_phone',
        'user_birthdate',
        'user_image_url',
        'user_forgot_password',
        'user_email_verified_at',
        'user_register_date',
        'user_notification_token',
        'user_language',
        'user_role',
        'remember_token'
    ];
    public function hasRole($role)
    {
        return $this->role === $role;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
}
