<?php

namespace App\Infrastructure\Doctrine\Product;

use App\Core\Domain\Common\EntityNotFound;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\Product;
use App\Core\Domain\Product\ProductRepositoryInterface;
use App\Core\Domain\User\User;
use App\Core\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Doctrine\DoctrineRepository;

final class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    public function get(UUID $uuid): Product
    {
        $user = $this->repository(Product::class)->find($uuid);
        if ($user === null) {
            throw new EntityNotFound('Продукт не найден.');
        }

        return $user;
    }

    public function save(Product $user): void
    {
        $this->internalPersist($user);
    }
}