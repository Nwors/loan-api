<?php

namespace App\Core\Application\Action\User;

use App\Core\Application\Common\Command;

final readonly class CreateUser implements Command
{
    public function __construct(
        public string $id,
        public string $firstName,
        public string $lastName,
        public int $age,
        public string $city,
        public string $usState,
        public string $ssn,
        public int $fico,
        public string $email,
        public string $phone,
    ) {
    }
}
