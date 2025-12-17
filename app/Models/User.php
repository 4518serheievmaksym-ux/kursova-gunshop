<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Ми прибрали HasApiTokens, залишили тільки те, що треба
    use HasFactory, Notifiable;

    /**
     * Атрибути, які можна масово заповнювати.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // 0 - клієнт, 1 - адмін
        'phone',    // Телефон клієнта
        'address',  // Адреса доставки
    ];

    /**
     * Атрибути, які слід приховати при серіалізації.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибути, які слід приводити до певних типів.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Зв'язок зі Схроном (Wishlist)
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}