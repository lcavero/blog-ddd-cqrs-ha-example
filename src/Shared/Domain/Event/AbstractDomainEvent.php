<?php

namespace App\Shared\Domain\Event;

abstract class AbstractDomainEvent implements DomainEvent
{
    protected string $eventName;
    protected int $createdOn;

    protected function __construct(string $eventName)
    {
        $this->eventName = $eventName;
        $this->createdOn = time();
    }

    public function createdOn(): int
    {
        return $this->createdOn;
    }

    public function eventName(): string
    {
        return $this->eventName;
    }
}
