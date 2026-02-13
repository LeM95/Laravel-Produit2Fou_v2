<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateBloquee extends Model
{
    protected $table = 'dates_bloquees';

    protected $fillable = [
        'date',
        'raison',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
