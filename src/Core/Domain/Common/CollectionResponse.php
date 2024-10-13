<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

final class CollectionResponse
{
    public function __construct(
        private array $items
    ) {
    }

    public function result(): mixed
    {
        return \reset($this->items);
    }

    public function results(): array
    {
        return $this->items;
    }
}