<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    public function types()
    {
        return $this->hasMany('App\Models\Type');
    }
    
}