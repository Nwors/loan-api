<?php

namespace App\Core\Application\Action\User;

use App\Core\Application\Common\Command;

final readonly class PartialUpdateUser implements Command
{
    public function __construct(
        public string $userId,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?int $age = null,
        public ?string $city = null,
        public ?string $usState = null,
        public ?string $ssn = null,
        public ?int $fico = null,
        public ?string $email = null,
        public ?string $phone = null,
    ) {
    }
}
