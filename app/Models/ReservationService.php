<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationService extends Model
{
    protected $table = 'reservation_services';

    protected $fillable = [
        'nom',
        'prix',
        'description',
    ];

    public function items()
    {
        return $this->hasMany(ReservationServiceItem::class, 'service_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'service_id');
    }

    // Get total products needed for this pack
    public function getTotalProductsAttribute()
    {
        return $this->items->sum('quantite');
    }
}
