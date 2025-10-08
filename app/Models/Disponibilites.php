<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Disponibilites extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_day',
        'id_time',
        'id_utilisateur',
    ];

    protected $table = 'disponibilites';

    protected $primaryKey = 'id_disponibilite';

    public function jour()
    {
        return $this->belongsTo(Jours::class, 'id_day', 'id_jour');
    }

    public function heure()
    {
        return $this->belongsTo(Heures::class, 'id_time', 'id_heure');
    }
}
