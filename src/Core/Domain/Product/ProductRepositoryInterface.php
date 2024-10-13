<?php

namespace App\Core\Domain\Product;

use App\Core\Domain\Common\UUID;
use App\Core\Domain\User\User;

interface ProductRepositoryInterface
{
    public function get(UUID $uuid): Product;
    public function save(Product $user): void;
}