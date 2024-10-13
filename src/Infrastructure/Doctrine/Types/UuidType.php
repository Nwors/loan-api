<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Types;

use App\Core\Domain\Common\UUID;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;

final class UuidType extends GuidType
{
    public const NAME = 'uuid';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof UUID) {
            return (string) $value;
        }

        return (string) UUID::fromValue($value);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UUID
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if ($value instanceof UUID) {
            return $value;
        }

        try {
            $entityUUID = UUID::fromValue($value);
        } catch (\InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }

        return $entityUUID;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getMappedDatabaseTypes(AbstractPlatform $platform): array
    {
        return [self::NAME];
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
