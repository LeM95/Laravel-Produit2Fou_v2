<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['service_id', 'titre', 'description', 'chemin_video', 'thumbnail', 'ordre'];

    // Une vidéo appartient à un service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
