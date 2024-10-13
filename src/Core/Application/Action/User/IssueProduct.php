<?php

namespace App\Core\Application\Action\User;

use App\Core\Application\Common\Command;

final readonly class IssueProduct implements Command
{
    public function __construct(
        public string $userId,
        public string $productId
    ) {
    }
}
