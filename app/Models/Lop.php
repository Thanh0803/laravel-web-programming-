<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;
    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
