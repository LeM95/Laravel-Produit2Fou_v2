<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationServiceItem extends Model
{
    protected $table = 'reservation_service_items';

    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'inventaire_id',
        'quantite',
    ];

    public function service()
    {
        return $this->belongsTo(ReservationService::class, 'service_id');
    }

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'inventaire_id');
    }
}
