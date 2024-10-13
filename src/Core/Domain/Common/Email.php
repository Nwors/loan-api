<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

class Email extends ValueObject
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
        return $valueObject instanceof Email && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Некорректное значение email.');
        }
    }
}