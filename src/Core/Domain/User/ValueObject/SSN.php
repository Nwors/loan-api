<?php

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class SSN extends ValueObject
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
        return $valueObject instanceof SSN && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!is_string($value) || !preg_match('/^\d{3}-\d{2}-\d{4}$/', $value)) {
            throw new \InvalidArgumentException('Некорректное значение SSN.');
        }
    }
}