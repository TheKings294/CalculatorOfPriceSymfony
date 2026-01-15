<?php

namespace App\Doctrine\Type;

use App\Doctrine\Type\PostgresEnumType;

class PrestationStatusEnumType extends PostgresEnumType
{
    public const NAME = 'prestation_status_enum';

    public static function getValues(): array {
        return ['draft', 'confirmed', 'completed', 'canceled'];
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
