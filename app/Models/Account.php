<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 'email','password', 'role', 
    ];
    public function teacher()
    {
        return $this->hasOne('App\Models\Teacher');
    }
    public function student()
    {
        return $this->hasOne('App\Models\Student');
    }
    public function admin()
    {
        return $this->hasOne('App\Models\Admin');
    }
}

