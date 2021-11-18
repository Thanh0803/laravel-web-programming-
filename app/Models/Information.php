<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 'email','password', 'role',
    ];
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
