<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Disponibilites extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_day',
        'id_time',
        'id_utilisateur',
    ];

    protected $table = 'disponibilites';

    protected $primaryKey = 'id_disponibilite';
}
