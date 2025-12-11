<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'produit_id',
        'chemin_image',
        'ordre',
    ];
    // Relation : Une image appartient à un produit
    public function produit()
    {
        return $this->belongsTo(Produits::class, 'produit_id');
    }
}
