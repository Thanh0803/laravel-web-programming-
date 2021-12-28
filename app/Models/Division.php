<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Division extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'student_id','lop_id',
    ];
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function lop()
    {
        return $this->belongsTo('App\Models\Lop');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
    
}