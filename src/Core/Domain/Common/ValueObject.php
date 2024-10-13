<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

abstract class ValueObject
{
    abstract function equals(ValueObject $valueObject): bool;

    public function notEquals($other): bool
    {
        return ! $this->equals($other);
    }
}