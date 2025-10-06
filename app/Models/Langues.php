<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Langues extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'libelle',
    ];

    protected $table = 'langues';

    protected $primaryKey = 'id_langue';
}
