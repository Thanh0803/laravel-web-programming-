<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Type extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'markName', 'markWeight'
    ];
    public function marks()
    {
        return $this->hasMany('App\Models\Mark');
    }
}
