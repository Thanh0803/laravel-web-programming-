<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Subject extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'subjectName', 'grade', 'subjectWeight', 'assign_id', 'mark_id'
    ];
    public function assigns()
    {
        return $this->hasMany('App\Models\Assign');
    }
    public function marks()
    {
        return $this->hasMany('App\Models\Mark');
    }
}
