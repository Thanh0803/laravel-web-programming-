<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'information_id', 'student_id'
    ];
    public function lop()
    {
        return $this->belongsTo('App\Models\Lop');
    }
    public function information()
    {
        return $this->belongsTo('App\Models\Information');
    }
    public function phuhuynh()
    {
        return $this->hasMany('App\Models\Phuhuynh');
    }
    public function OauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }

}
