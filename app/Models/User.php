<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable 
{
    use HasApiTokens,HasFactory, Notifiable;
    use HasRoles; 

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = [ 'password', 'remember_token' ];
    

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}