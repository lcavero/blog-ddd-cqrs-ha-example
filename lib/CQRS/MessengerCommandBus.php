<?php

namespace Lib\CQRS;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $messageBus)
    {}

    public function dispatch(Command $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }
            throw $e;
        }
    }
}
