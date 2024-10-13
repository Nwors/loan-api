<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;

abstract class DomainEvent
{
    public string $eventName;
    public string $eventId;
    public \DateTimeImmutable $occurredOn;

    public function __construct(
        ?string $eventName = null,
        ?string $eventId = null,
        ?\DateTimeImmutable $occurredOn = null,
    ) {
        $this->eventName = $eventName ?? static::class;
        $this->eventId = $eventId ?? UUID::generate();
        $this->occurredOn = $occurredOn ?: new \DateTimeImmutable();
    }

    public function occurredOn(): string
    {
        return $this->occurredOn->format(\DateTimeImmutable::ATOM);
    }

    public function name(): string
    {
        return $this->eventName;
    }
}