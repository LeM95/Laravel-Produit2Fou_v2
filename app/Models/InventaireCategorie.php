<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventaireCategorie extends Model
{
    protected $table = 'inventaire_categories';

    protected $fillable = ['nom'];

    public function items()
    {
        return $this->hasMany(Inventaire::class, 'categorie_id');
    }
}
