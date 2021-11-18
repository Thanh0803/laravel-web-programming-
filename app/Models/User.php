<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     
    *protected $fillable = [
    *    'name',
    *    'email',
    *    'password',
    *];
    */
    protected $fillable = [
        'information_id',
    ];
    public function level()
    {
        return $this->belongsTo('App\Models\Level');
    }
    public function information()
    {
        return $this->belongsTo('App\Models\Information');
    }
    public function lops()
    {
        return $this->hasMany('App\Models\Lop');
    }
    public function OauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }
}
