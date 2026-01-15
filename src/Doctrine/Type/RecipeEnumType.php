<?php

namespace App\Doctrine\Type;

use App\Doctrine\Type\PostgresEnumType;

class RecipeEnumType extends PostgresEnumType
{
    public const NAME = 'recipe_enum';

    public static function getValues(): array {
        return ['starter', 'main', 'dessert', 'side', 'drink'];
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
