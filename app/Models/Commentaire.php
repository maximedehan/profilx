<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_admin',
        'id_profil',
    ];

    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'id_admin');
    }

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'id_profil');
    }
}
