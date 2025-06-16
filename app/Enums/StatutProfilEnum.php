<?php

namespace App\Enums;

enum StatutProfilEnum: string
{
    case Actif = 'actif';
    case Inactif = 'inactif';
    case EnAttente = 'en_attente';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
