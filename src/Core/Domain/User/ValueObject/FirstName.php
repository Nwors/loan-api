<?php

declare(strict_types=1);

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class FirstName extends ValueObject
{
    public function __construct(public readonly string $value) {
        self::validate($this->value);
    }

    public static function fromValue(string $value): self
    {
        return new self($value);
    }

    function equals(ValueObject $valueObject): bool
    {
        if ($valueObject instanceof FirstName && $valueObject->value === $this->value) {
            return true;
        }

        return false;
    }

    public static function validate(mixed $value): void
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException('Некорректное значение имени.');
        }
    }
}