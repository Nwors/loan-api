<?php

declare(strict_types=1);

namespace App\Core\Application\ActionHandler\User;

use App\Core\Application\Action\User\PartialUpdateUser;
use App\Core\Application\Common\CommandHandler;
use App\Core\Domain\Common\Email;
use App\Core\Domain\Common\Phone;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\User\UserRepositoryInterface;
use App\Core\Domain\User\ValueObject\Age;
use App\Core\Domain\User\ValueObject\City;
use App\Core\Domain\User\ValueObject\Fico;
use App\Core\Domain\User\ValueObject\FirstName;
use App\Core\Domain\User\ValueObject\LastName;
use App\Core\Domain\User\ValueObject\USState;

final readonly class PartialUpdateUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(PartialUpdateUser $command): void
    {
        $user = $this->userRepository->get(UUID::fromValue($command->userId));

        $user->update(
            $command->firstName ? FirstName::fromValue($command->firstName) : null,
            $command->lastName ? LastName::fromValue($command->lastName) : null,
            $command->age ? Age::fromValue($command->age) : null,
            $command->city ? City::fromValue($command->city) : null,
            $command->usState ? USState::fromValue($command->usState) : null,
            $command->fico ? Fico::fromValue($command->fico) : null,
            $command->email ? Email::fromValue($command->email) : null,
            $command->phone ? Phone::fromValue($command->phone) : null
        );

        $this->userRepository->save($user);
    }
}
