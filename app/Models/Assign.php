<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Assign extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'assign_id','lop_id', 'subject_id'
    ];
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function lop()
    {
        return $this->belongsTo('App\Models\Lop');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
