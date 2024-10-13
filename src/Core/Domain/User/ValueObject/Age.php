<?php

declare(strict_types=1);

namespace App\Core\Domain\User\ValueObject;

use App\Core\Domain\Common\ValueObject;

class Age extends ValueObject
{
    public const MIN_PRODUCT_AGE = 18;
    public const MAX_PRODUCT_AGE = 60;

    public function __construct(public readonly int $value) {
        self::validate($this->value);
    }

    public static function fromValue(int $value): self
    {
        return new self($value);
    }

    function equals(ValueObject $valueObject): bool
    {
        if ($valueObject instanceof Age && $valueObject->value === $this->value) {
            return true;
        }

        return false;
    }

    public static function validate(mixed $value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException('Некорректное значение возраста.');
        }
    }
}
