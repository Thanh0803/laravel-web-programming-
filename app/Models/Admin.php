<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'username', 'password',
    ];
    public function levels()
    {
        return $this->hasMany('App\Models\Level');
    }

    public function OauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken','user_id','id');
    }

}
