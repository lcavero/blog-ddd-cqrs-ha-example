<?php

namespace App\Shared\Domain\Event;

trait DomainEventsRecorderTrait
{
    private array $domainEvents = [];

    public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
