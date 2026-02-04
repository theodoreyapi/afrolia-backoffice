<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Politicy extends Model
{
    protected $table = 'politicy';
    protected $primaryKey = 'id_politicy';

    protected $fillable = [
        'politicy',
    ];
}
