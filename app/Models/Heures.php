<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Heures extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'libelle',
    ];

    protected $table = 'heures';

    protected $primaryKey = 'id_heure';
}
