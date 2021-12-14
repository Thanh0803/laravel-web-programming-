<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Lop extends Model
{
    use HasFactory, Notifiable;   
    protected $fillable = [
        'classname', 'grade_id', 'teacher_id'
    ];
    public function divisions()
    {
        return $this->hasMany('App\Models\Division');
    }
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
