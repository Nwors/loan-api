<?php

namespace App\Infrastructure\Doctrine\User;

use App\Core\Domain\Common\EntityNotFound;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\User\User;
use App\Core\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Doctrine\DoctrineRepository;

final class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    public function get(UUID $uuid): User
    {
        $user = $this->repository(User::class)->find($uuid);
        if ($user === null) {
            throw new EntityNotFound('Пользователь не найден.');
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->internalPersist($user);
    }
}