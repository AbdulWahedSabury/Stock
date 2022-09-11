<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $paginationTheme = 'bootstrap';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];
    public $ROLE_ADMIN = 'admin';
    public $ROLE_USER = "user";

    public function getRecord($id)
    {
        return self::findOrFail($id);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends=[
        'avatar_url',
    ];

    public function getAvatarUrlAttribute()
    {
        if($this->avatar){
            return asset('storage/avatars/'.$this->avatar);
        }else{
            return asset('deafult.png');
        }
    }

    public function isAdmin()
    {
        if($this->role != $this->ROLE_ADMIN){
            return false;
        }
        return true;
    }

}
