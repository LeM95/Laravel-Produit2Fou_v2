<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    protected $table = 'inventaire';

    protected $fillable = [
        'nom',
        'description',
        'emplacement',
        'prix_achat',
        'stock',
        'stock_min',
        'categorie_id',
        'photo',
        'fournisseur',
    ];

    public function categorie()
    {
        return $this->belongsTo(InventaireCategorie::class, 'categorie_id');
    }

    public function mouvements()
    {
        return $this->hasMany(InventaireMouvement::class, 'inventaire_id')->orderBy('created_at', 'desc');
    }

    public function isLowStock()
    {
        return $this->stock <= $this->stock_min;
    }
}
