<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Security extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'description',
    ];

    protected $table = 'security';

    protected $primaryKey = 'id_security';
}
