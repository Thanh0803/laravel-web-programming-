<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Type extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'subject_id'
    ];
    public function divisions()
    {
        return $this->hasMany('App\Models\Division');
    }
    public function fifs()
    {
        return $this->hasMany('App\Models\Fif');
    }
    public function forts()
    {
        return $this->hasMany('App\Models\Fort');
    }
    public function nines()
    {
        return $this->hasMany('App\Models\Nine');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}