<?php

namespace App\Core\Domain\User\Events;

use App\Core\Domain\Common\DomainEvent;

final class UserCreated extends DomainEvent
{
    public function __construct(
        public readonly string $id,
        public readonly string $email
    ) {
        parent::__construct();
    }
}