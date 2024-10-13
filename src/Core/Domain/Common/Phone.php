<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

class Phone extends ValueObject
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
        return $valueObject instanceof Phone && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!preg_match('/^\+?\d{1,3}[-\s]?\(?\d{1,4}\)?[-\s]?\d{1,4}[-\s]?\d{1,9}$/', $value)) {
            throw new \InvalidArgumentException('Некорректное значение телефона.');
        }
    }
}