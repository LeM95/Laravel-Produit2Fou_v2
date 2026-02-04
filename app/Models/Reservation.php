<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'date_reservation',
        'client_nom',
        'client_telephone',
        'ville',
        'adresse',
        'type_mur',
        'prix',
        'description',
        'acompte',
        'service_id',
        'statut',
    ];

    protected $casts = [
        'date_reservation' => 'date',
        'acompte' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(ReservationService::class, 'service_id');
    }

    public function photos()
    {
        return $this->hasMany(ReservationPhoto::class, 'reservation_id');
    }

    public function produits()
    {
        return $this->belongsToMany(Produits::class, 'reservation_produits', 'reservation_id', 'produit_id')
            ->withPivot('notes');
    }

    public function getStatutLabelAttribute()
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'confirme' => 'Confirmé',
            'termine' => 'Terminé',
            'annule' => 'Annulé',
            default => $this->statut
        };
    }

    public function getStatutColorAttribute()
    {
        return match($this->statut) {
            'en_attente' => '#ffc107',
            'confirme' => '#28a745',
            'termine' => '#6c757d',
            'annule' => '#dc3545',
            default => '#999'
        };
    }
}
