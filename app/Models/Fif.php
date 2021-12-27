<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Fif extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
}