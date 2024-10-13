<?php

declare(strict_types=1);

namespace App\Core\Domain\User;

use App\Core\Domain\Common\AggregateRoot;
use App\Core\Domain\Common\Email;
use App\Core\Domain\Common\Phone;
use App\Core\Domain\Common\UUID;
use App\Core\Domain\Product\Product;
use App\Core\Domain\User\Events\UserCreated;
use App\Core\Domain\User\ValueObject\Age;
use App\Core\Domain\User\ValueObject\City;
use App\Core\Domain\User\ValueObject\Fico;
use App\Core\Domain\User\ValueObject\FirstName;
use App\Core\Domain\User\ValueObject\LastName;
use App\Core\Domain\User\ValueObject\SSN;
use App\Core\Domain\User\ValueObject\USState;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;

class User extends AggregateRoot
{
    private const float CA_EXTRA = 11.49;

    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public static function create(
        UUID $id,
        FirstName $firstName,
        LastName $lastName,
        Age $age,
        City $city,
        USState $USState,
        SSN $ssn,
        Fico $fico,
        Email $email,
        Phone $phone
    ) {
        return new self(
            id: $id,
            firstName: $firstName,
            lastName: $lastName,
            age: $age,
            city: $city,
            USState: $USState,
            ssn: $ssn,
            fico: $fico,
            email: $email,
            phone: $phone
        );
    }
    protected function __construct(
        UUID $id,
        private FirstName $firstName,
        private LastName $lastName,
        private Age $age,
        private City $city,
        private USState $USState,
        private SSN $ssn,
        private Fico $fico,
        private Email $email,
        private Phone $phone,
        private Collection $products = new ArrayCollection()
    ) {
        $this->setId($id);

        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new UserCreated($id->value, $this->email->value));
    }

    public function name(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function age(): Age
    {
        return $this->age;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function USState(): USState
    {
        return $this->USState;
    }

    public function ssn(): SSN
    {
        return $this->ssn;
    }

    public function fico(): Fico
    {
        return $this->fico;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function phone(): Phone
    {
        return $this->phone;
    }

    public function products(): ReadableCollection
    {
        return $this->products;
    }

    public function update(
        ?FirstName $firstName = null,
        ?LastName $lastName = null,
        ?Age $age = null,
        ?City $city = null,
        ?USState $USState = null,
        ?Fico $fico = null,
        ?Email $email = null,
        ?Phone $phone = null
    ): void {
        $updated = false;

        if ($firstName !== null && !$this->firstName->equals($firstName)) {
            $this->firstName = $firstName;
            $updated = true;
        }

        if ($lastName !== null && !$this->lastName->equals($lastName)) {
            $this->lastName = $lastName;
            $updated = true;
        }

        if ($age !== null && !$this->age->equals($age)) {
            $this->age = $age;
            $updated = true;
        }

        if ($city !== null && !$this->city->equals($city)) {
            $this->city = $city;
            $updated = true;
        }

        if ($USState !== null && !$this->USState->equals($USState)) {
            $this->USState = $USState;
            $updated = true;
        }

        if ($fico !== null && !$this->fico->equals($fico)) {
            $this->fico = $fico;
            $updated = true;
        }

        if ($email !== null && !$this->email->equals($email)) {
            $this->email = $email;
            $updated = true;
        }

        if ($phone !== null && !$this->phone->equals($phone)) {
            $this->phone = $phone;
            $updated = true;
        }

        if ($updated) {
            $this->updatedAt = new \DateTimeImmutable();
            // Создание события
            // $this->recordEvent(new UserUpdated($this->id, $this->email->value));
        }
    }

    public function issueProduct(Product $product): void
    {
        $product->canBeIssuedTo($this);

        // По хорошему всю эту логику надо инкапсулировать в VO.
        $interestRate = $this->USState()->equals(USState::fromValue('CA')) ?
            ($product->interestRate() + self::CA_EXTRA) : $product->interestRate();

        $userProduct = UserProduct::create(
            id: UUID::fromValue(UUID::generate()),
            user: $this,
            product: $product,
            interestRate: $interestRate
        );

        $this->products->add($userProduct);

        $this->updatedAt = new \DateTimeImmutable();
        // Здесь должно записываться событие по которому в последствии отправится уведомление через EventSubscriber.
        //$this->recordEvent(new ProductIssued($this->id()->value, $product->id()->value));
    }
}
