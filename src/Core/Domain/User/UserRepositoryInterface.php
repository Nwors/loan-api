<?php

namespace App\Core\Domain\User;

use App\Core\Domain\Common\UUID;

interface UserRepositoryInterface
{
    public function get(UUID $uuid): User;
    public function save(User $user): void;
}