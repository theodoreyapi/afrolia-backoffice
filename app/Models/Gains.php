<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Gains extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_coiffeur',
        'id_reservation',
        'montant_brut',
        'montant_commission',
        'montant_net',
        'statut',
        'date_paiement',
    ];

    protected $table = 'gains';

    protected $primaryKey = 'id_gain';
}
