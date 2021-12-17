<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Conduct extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'student_id', 'mark', 'semester'
    ];
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
