<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Paiements extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_reservation',
        'payment_intent_id',
        'amount',
        'currency',
        'payment_method',
        'provider_transaction_id',
        'status',
        'failure_reason',
        'processed_at',
    ];

    protected $table = 'paiements';

    protected $primaryKey = 'id_paiement';
}
