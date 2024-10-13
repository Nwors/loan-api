<?php

declare(strict_types=1);

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class City extends ValueObject
{
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
        return $valueObject instanceof City && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException('Некорректное значение города.');
        }
    }
}