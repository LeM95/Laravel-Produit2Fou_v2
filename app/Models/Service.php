<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['nom', 'description', 'image'];

    // Un service a plusieurs vidéos
    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('ordre');
    }
}
