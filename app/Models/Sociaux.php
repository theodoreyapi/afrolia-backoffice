<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sociaux extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'instagram',
        'facebook',
        'whatsapp',
        'tiktok',
        'id_utilisateur',
    ];

    protected $table = 'sociaux';

    protected $primaryKey = 'id_sociaux';
}
