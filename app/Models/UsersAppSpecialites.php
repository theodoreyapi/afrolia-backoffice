<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersAppSpecialites extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_utilisateur',
        'id_speciale',
    ];

    protected $table = 'users_app_specialites';

    protected $primaryKey = 'id_users_app_specialite';
}
