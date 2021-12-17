<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mark extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'type_id','student_id', 'subject_id', 'mark'
    ];
    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
}
