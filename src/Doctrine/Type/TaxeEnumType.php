<?php

namespace App\Doctrine\Type;

use App\Doctrine\Type\PostgresEnumType;

class TaxeEnumType extends PostgresEnumType
{
    public const NAME = 'taxe_enum';

    public static function getValues(): array {
        return ['no_tva', 'tva_5_5', 'tva_10', 'tva_20'];
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
