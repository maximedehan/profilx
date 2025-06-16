<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom'];

    public function profils()
    {
        return $this->hasMany(Profil::class, 'id_admin');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_admin');
    }
}
