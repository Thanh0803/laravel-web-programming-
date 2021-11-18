<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
    public function teachers()
    {
        return $this->hasMany('App\Models\User');
    }
}
