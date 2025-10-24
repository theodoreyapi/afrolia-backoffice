<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClientFavorite extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id',
        'stylist_id',
    ];

    protected $table = 'client_favorites';

    protected $primaryKey = 'id_client_favorite';

    // Relations
    public function client()
    {
        return $this->belongsTo(UsersApp::class, 'client_id');
    }

    public function stylist()
    {
        return $this->belongsTo(UsersApp::class, 'stylist_id');
    }
}
