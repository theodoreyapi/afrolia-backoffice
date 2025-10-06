<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersAppMethodePaiement extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_methode',
        'id_utilisateur',
    ];

    protected $table = 'users_app_methode_paiement';

    protected $primaryKey = 'id_users_app_methode_paiement';
}
