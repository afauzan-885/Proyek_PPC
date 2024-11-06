<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reset_request_status', 
        'tentang_saya',
        'kontak',
        'tanggal_lahir',
        'role',
        'is_active',
        'photo',
    ];
    

    protected $hidden = [
        'password',
        'remember',
    ];
}
