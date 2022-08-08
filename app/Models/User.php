<?php

namespace App\Models;

use App\Helper\Tokenable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Tokenable;

    public $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthToken($request)
    {
        return str_replace('Bearer ', '', $request->header('Authorization'));
    }

    public function getAuthUser($request)
    {
        return $this->where('api_token', $this->getAuthToken($request))->first();
    }

    public function getPermissions($key)
    {
        $role = Role::find($this->role_id);
        $permissions = json_decode($role->permissions, true);
        return isset($permissions[$key]) ? $permissions[$key] : null;
    }
}
