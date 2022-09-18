<?php

namespace App\Models;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public $roles = [
        'ADMIN' => [],
        'EDITOR' => ['ADMIN'],
        'CREATOR' => ['ADMIN', 'EDITOR'],
        'REPORTER' => ['ADMIN', 'EDITOR', 'CREATOR'],
    ];

    const ROLEPERMISSIONS = [
        'REPORTER' => 'REPORTER',
        'CREATOR' => 'CREATOR',
        'EDITOR' => 'EDITOR',
        'ADMIN' => 'ADMIN',
    ];


    public function getRecord($id)
    {
        return self::findOrFail($id);
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url',
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/avatars/' . $this->avatar);
        } else {
            return asset('deafult.png');
        }
    }


    public function hasValidRole(String $role): bool
    {
        if (!array_key_exists($role, $this->roles)) {
            return false;
        }
        return true;
    }

    public function hasAuthMinRole(String $role): bool
    {
        return in_array(Auth::user()->role, Auth::user()->getCoveredRolesOfRole($role));
    }

    public function getCoveredRolesOfRole(String $role): array
    {
        $roles = $this->roles;

        if (!array_key_exists($role, $roles)) {
            throw new Exception('The role is not found');
        }

        return array_merge([$role], $roles[$role]);
    }

    public function getRoleList()
    {
        $roles = static::ROLEPERMISSIONS;
        return $roles;
    }

}
