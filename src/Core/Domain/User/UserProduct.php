<?php

declare(strict_types=1);

namespace App\Core\Domain\User;

use App\Core\Domain\Common\Entity;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\Product;

class UserProduct extends Entity
{
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public static function create(
        UUID $id,
        User $user,
        Product $product,
        float $interestRate
    ): self {
        return new self(
            id: $id,
            user: $user,
            product: $product,
            interestRate: $interestRate
        );
    }

    // По-хорошему в момент создания полностью отвязываться от сущности продукт, и перефиксировать все поля
    // в эту сущность, но так как по условию только кредитная ставка изменяется (в зависимости от штата)
    // и не предусмотрено изменение продукта зафиксируем только её.
    private function __construct(
        UUID $id,
        private User $user,
        private Product $product,
        private float $interestRate
    ) {
        $this->setId($id);
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function user(): User
    {
        return $this->user;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function interestRate(): float
    {
        return $this->interestRate;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
