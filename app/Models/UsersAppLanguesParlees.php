<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersAppLanguesParlees extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_utilisateur',
        'id_language',
    ];

    protected $table = 'users_app_langues_parlees';

    protected $primaryKey = 'id_user_app_langue_parle';
}
