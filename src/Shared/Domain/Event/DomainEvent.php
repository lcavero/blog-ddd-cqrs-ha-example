<?php

namespace App\Shared\Domain\Event;

interface DomainEvent
{
    public function createdOn(): int;
    public function eventName(): string;
}
