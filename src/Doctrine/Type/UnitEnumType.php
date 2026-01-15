<?php

namespace App\Doctrine\Type;

use App\Doctrine\Type\PostgresEnumType;
use Doctrine\DBAL\Types\Type;

class UnitEnumType extends PostgresEnumType
{
    public const NAME = 'unit_enum';

    public static function getValues(): array {
        return ['g', 'kg', 'ml', 'l', 'piece'];
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
