<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Gallery extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'image',
        'description',
        'id_utilisateur',
    ];

    protected $table = 'gallery';

    protected $primaryKey = 'id_gallery';
}
