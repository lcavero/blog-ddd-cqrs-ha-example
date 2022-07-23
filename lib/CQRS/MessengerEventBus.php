<?php

namespace Lib\CQRS;

use App\Shared\Domain\Event\DomainEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $messageBus)
    {}

    public function dispatch(DomainEvent $event): void
    {
        try {
            $this->messageBus->dispatch($event);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }
            throw $e;
        }
    }
}
