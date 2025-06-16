<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_admin',
        'nom',
        'prenom',
        'image',
        'statut',
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'id_admin');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_profil');
    }
}
