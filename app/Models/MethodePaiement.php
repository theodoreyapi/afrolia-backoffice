<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MethodePaiement extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'libelle',
    ];

    protected $table = 'methode_paiement';

    protected $primaryKey = 'id_methode_paiement';
}
