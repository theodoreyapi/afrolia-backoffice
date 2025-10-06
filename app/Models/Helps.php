<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Helps extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'description',
    ];

    protected $table = 'helps';

    protected $primaryKey = 'id_help';
}
