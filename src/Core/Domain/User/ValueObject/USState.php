<?php

declare(strict_types=1);

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class USState extends ValueObject
{
    // TODO Понятно, что это должно быть в БД, чтобы каждый раз в код не лезть при добавлении нового штата.
    // Хотя, это навреное не так часто случается) Но хотябы список разрешенных явно должен быть динамичным.
    public const CA = 'CA';
    public const NY = 'NY';
    public const NV = 'NV';
    public const ND = 'ND';
    public const SD = 'SD';

    public const AVAILABLE_STATES = [
        self::CA,
        self::NY,
        self::NV
    ];

    public const STATES = [
        self::CA,
        self::NY,
        self::NV,
        self::ND,
        self::SD,
    ];

    public function __construct(public readonly string $value)
    {
        self::validate($this->value);
    }

    public static function fromValue(string $value): self
    {
        return new self($value);
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof USState && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!is_string($value) && in_array($value, self::STATES, true)) {
            throw new \InvalidArgumentException('Некорректное значение штата.');
        }
    }
}
