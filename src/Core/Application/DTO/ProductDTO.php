<?php

declare(strict_types=1);

namespace App\Core\Application\DTO;

use App\Core\Domain\Product\Product;

final readonly class ProductDTO
{
    public static function fromObject(Product $object): self
    {
        return new self(
            id: $object->id()->value(),
            name: $object->name(),
            loanTerm: $object->loanTerm(),
            interestRate: $object->interestRate(),
            amount: $object->amount(),
            createdAt: $object->createdAt()->format(\DateTimeInterface::ATOM),
            updatedAt: $object->updatedAt()->format(\DateTimeInterface::ATOM)
        );
    }

    public function __construct(
        public string $id,
        public string $name,
        public int $loanTerm,
        public float $interestRate,
        public float $amount,
        public string $createdAt,
        public string $updatedAt
    ) {
    }
}
