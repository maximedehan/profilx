<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrateur extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticableTrait;

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
