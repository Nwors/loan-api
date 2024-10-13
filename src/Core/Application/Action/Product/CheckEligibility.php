<?php

declare(strict_types=1);

namespace App\Core\Application\Action\Product;

use App\Core\Application\Common\Query;

final readonly class CheckEligibility implements Query
{
    public function __construct(
        public string $productId,
        public string $userId
    ) {
    }
}
