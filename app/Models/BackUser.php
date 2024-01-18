<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BackUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'backofficeusers'; // Modelin "users" tablosuna bağlı olduğunu belirtir
    protected $primaryKey = 'id'; // user_id alanını primary key olarak belirtin
    protected $fillable = [
        'id',
        'backuser_id',
        'backuser_mail',
        'backuser_name',
        'backuser_password',
        'backuser_phone',
        'backuser_birthdate',
        'backuser_image_url',
        'backuser_forgot_password',
        'user_email_verified_at',
        'backuser_register_date',
        'backuser_notification_token',
        'backuser_language',
        'backuser_role',
        'remember_token'
    ];
    public function hasRole($role)
    {
        return $this->backuser_role === $role;
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
