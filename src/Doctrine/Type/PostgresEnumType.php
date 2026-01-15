<?php

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class PostgresEnumType extends Type {
    abstract public static function getValues(): array;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "VARCHAR(10)";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?string
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!in_array($value, static::getValues(), true)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid value "%s" for ENUM "%s". Allowed values: %s',
                $value,
                $this->getName(),
                implode(', ', static::getValues())
            ));
        }

        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}


/*
 * $this->addSql('CREATE TYPE prestation_status_enum AS ENUM (\'draft\', \'confirmed\', \'completed\', \'canceled\')');
        $this->addSql('CREATE TYPE recipe_enum AS ENUM (\'starter\', \'main\', \'dessert\', \'side\', \'drink\')');
        $this->addSql('CREATE TYPE taxe_enum AS ENUM (\'no_tva\', \'tva_5_5\', \'tva_10\', \'tva_20\')');
        $this->addSql('CREATE TYPE unit_enum AS ENUM (\'g\', \'kg\', \'ml\', \'l\', \'piece\')');
 * */
