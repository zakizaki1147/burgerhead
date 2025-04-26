<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'full_name', 'username', 'password', 'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'transaction_id', 'transaction_id');
    }
}

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array<int, string>
//      */

//     /**
//      * The attributes that should be hidden for serialization.
//      *
//      * @var array<int, string>
//      */

//     /**
//      * Get the attributes that should be cast.
//      *
//      * @return array<string, string>
//      */
//     protected function casts(): array
//     {
//         return [
//             'email_verified_at' => 'datetime',
//             'password' => 'hashed',
//         ];
//     }
// }