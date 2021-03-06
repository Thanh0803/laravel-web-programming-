<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'account_id',
    ];
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
    public function OauthAcessToken()
    {
        return $this->hasMany('App\Models\OauthAccessToken','user_id','id');
    }
}
