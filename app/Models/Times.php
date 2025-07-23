<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
    protected $fillable = ['hour', 'is_active'];

    protected $casts = [
        'hour' => 'datetime:H:i', // Formato de armazenamento
    ];
}
