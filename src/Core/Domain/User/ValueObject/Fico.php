<?php

declare(strict_types=1);

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class Fico extends ValueObject
{
    public function __construct(public readonly int $value)
    {
        self::validate($this->value);
    }

    public static function fromValue(int $value): self
    {
        return new self($value);
    }

    public function equals(ValueObject $valueObject): bool
    {
        return $valueObject instanceof Fico && $valueObject->value === $this->value;
    }

    public static function validate(mixed $value): void
    {
        if (!is_int($value) || $value < 300 || $value > 850) {
            throw new \InvalidArgumentException('Некорректное значение FICO.');
        }
    }
}