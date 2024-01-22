<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
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
        'email_verified_at',
        'user_register_date',
        'user_notification_token',
        'user_language',
        'user_role',
        'remember_token',
        'user_identity'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_password' => 'hashed',
    ];
}
