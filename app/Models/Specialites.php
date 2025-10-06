<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Specialites extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'libelle',
    ];

    protected $table = 'specialites';

    protected $primaryKey = 'id_specialite';
}
