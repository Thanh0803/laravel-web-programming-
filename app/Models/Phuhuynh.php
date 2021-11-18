<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Phuhuynh extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'information_id',
    ];
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function information()
    {
        return $this->belongsTo('App\Models\Information');
    }
    public function OauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }
}
