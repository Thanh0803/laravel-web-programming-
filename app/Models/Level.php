<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Level extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'teacher_id','subject_id'
    ];
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
}
