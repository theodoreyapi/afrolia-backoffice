<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersApp extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'photo',
        'name',
        'last_name',
        'phone',
        'email',
        'presentation',
        'commune',
        'adresse',
        'experience',
        'password',
        'role',
        'otp',
        'statut',
    ];

    protected $table = 'users_app';

    protected $primaryKey = 'id_user_app';
}
