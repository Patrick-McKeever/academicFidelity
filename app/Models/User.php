<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Models\group;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'userType'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //group memberships;
    public function memberships() {
        return $this->hasMany(groupMember::class, 'userId');
    }

    //classes created by user;
    public function classes() {
        return self::hasMany(userOwnedClass::class, 'ownerId');
    }
}
