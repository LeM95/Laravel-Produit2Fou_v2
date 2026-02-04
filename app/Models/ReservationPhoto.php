<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationPhoto extends Model
{
    protected $table = 'reservation_photos';

    public $timestamps = false;

    protected $fillable = [
        'reservation_id',
        'chemin_photo',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
