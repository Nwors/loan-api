<?php

declare(strict_types=1);

namespace App\Core\Domain\Product;

use App\Core\Domain\Common\AggregateRoot;
use App\Core\Domain\Common\DomainException;
use App\Core\Domain\User\User;
use App\Core\Domain\User\ValueObject\Age;
use App\Core\Domain\User\ValueObject\USState;

class Product extends AggregateRoot
{
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public static function create(
        string $name,
        int $loanTerm,
        float $interestRate,
        float $amount
    ): self {
        return new self($name, $loanTerm, $interestRate, $amount);
    }

    private function __construct(
        private string $name,
        private int $loanTerm,
        private float $interestRate,
        private float $amount
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function loanTerm(): int
    {
        return $this->loanTerm;
    }

    public function interestRate(): float
    {
        return $this->interestRate;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function canBeIssuedTo(User $user): void
    {
        $errors = [];

        if (!in_array($user->USState()->value, USState::AVAILABLE_STATES, true)) {
            $errors[] = 'Штат не подходит для выдачи продукта.';
        }

        if ($user->age()->value < Age::MIN_PRODUCT_AGE || $user->age()->value > Age::MAX_PRODUCT_AGE) {
            $errors[] = 'Возраст не подходит для выдачи продукта';
        }

        if ($user->USState()->value === USState::NY) {
            if ((rand(0, 1) === 0)) {
                $errors[] = 'Вам отказано в случайном порядке';
            }
        }

        if (!empty($errors)) {
            throw new DomainException(implode(", ", $errors));
        }
    }
}
