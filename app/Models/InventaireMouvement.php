<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventaireMouvement extends Model
{
    protected $table = 'inventaire_mouvements';

    public $timestamps = false;

    protected $fillable = [
        'inventaire_id',
        'type',
        'quantite',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'inventaire_id');
    }
}
