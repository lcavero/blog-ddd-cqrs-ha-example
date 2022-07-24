<?php

namespace App\Tests\Lib\Event;

use App\Shared\Domain\Aggregate\AggregateRoot;

class DomainEventTester
{
    public static function domainEventWasCreated(AggregateRoot $aggregateRoot, string $eventClass): bool
    {
        $domainEvents = $aggregateRoot->pullDomainEvents();
        if (count($domainEvents) < 1) {
            return false;
        }

        return $domainEvents[0] instanceof $eventClass;
    }
}
