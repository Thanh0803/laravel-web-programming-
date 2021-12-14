<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Grade extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'gradeName','grade'
    ];
    public function lops()
    {
        return $this->hasMany('App\Models\Lop');
    }
}
