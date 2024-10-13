<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

abstract class Entity
{
    protected UUID $id;

    public function id(): UUID
    {
        return $this->id;
    }

    protected function setId(UUID $id): void
    {
        $this->id = $id;
    }

    public function equals(mixed $other): bool
    {
        if (! $other instanceof self) {
            return false;
        }

        if ($other === $this) {
            return true;
        }

        $currentId = $this->id();
        $otherId = $other->id();

        return $currentId === $otherId;
    }
}
