<?php

declare(strict_types=1);

namespace App\Core\Domain\Common;


abstract class AggregateRoot extends Entity
{
    private array $events = [];

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->clearEvents();

        return $events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }

    protected function recordEvent(DomainEvent $event, bool $force = false): void
    {
        if (!isset($this->recordedEvents[$event->name()])) {
            $this->events[] = $event;
        } elseif ($force === true) {
            $this->events[] = $event;
        }
    }
}
