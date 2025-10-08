<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reservations extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'numero_reservation',
        'id_client',
        'id_coiffeur',
        'id_service',
        'date_reservation',
        'heure_reservation',
        'statut',
        'prix_service',
        'montant_commission',
        'montant_total',
        'statut_paiement',
        'methode_paiement',
        'notes',
        'raison_annulation',
        'annule_par',
        'annule_le',
        'confirme_le',
        'termine_le',
    ];

    protected $table = 'reservations';

    protected $primaryKey = 'id_reservation';
}
