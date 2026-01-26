<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    protected $table = 'produits';

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'ordre',
        'visible',
    ];
    // Relation : Un produit a plusieurs images
    public function images()
    {
        return $this->hasMany(Image::class, 'produit_id');
    }
}
