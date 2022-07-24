<?php

namespace App\Shared\Domain\Aggregate;

interface AggregateRoot
{
    public function pullDomainEvents(): array;
}
