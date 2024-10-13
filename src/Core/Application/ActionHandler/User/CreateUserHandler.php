<?php

declare(strict_types=1);

namespace App\Core\Application\ActionHandler\User;

use App\Core\Application\Action\User\CreateUser;
use App\Core\Application\Common\CommandHandler;
use App\Core\Domain\Common\Email;
use App\Core\Domain\Common\Phone;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\User\User;
use App\Core\Domain\User\UserRepositoryInterface;
use App\Core\Domain\User\ValueObject\Age;
use App\Core\Domain\User\ValueObject\City;
use App\Core\Domain\User\ValueObject\Fico;
use App\Core\Domain\User\ValueObject\FirstName;
use App\Core\Domain\User\ValueObject\LastName;
use App\Core\Domain\User\ValueObject\SSN;
use App\Core\Domain\User\ValueObject\USState;

final readonly class CreateUserHandler implements CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(CreateUser $command): void
    {
        $user = User::create(
            id: UUID::fromValue($command->id),
            firstName: FirstName::fromValue($command->firstName),
            lastName: LastName::fromValue($command->lastName),
            age: Age::fromValue($command->age),
            city: City::fromValue($command->city),
            USState: USState::fromValue($command->usState),
            ssn: SSN::fromValue($command->ssn),
            fico: Fico::fromValue($command->fico),
            email: Email::fromValue($command->email),
            phone: Phone::fromValue($command->phone)
        );

        $this->userRepository->save($user);

        //TODO Доменные эвенты должны попадать в шину событий.
        //$user->releaseEvents();
    }
}
