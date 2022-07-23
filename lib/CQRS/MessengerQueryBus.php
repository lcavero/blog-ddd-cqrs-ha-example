<?php

namespace Lib\CQRS;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(private MessageBusInterface $messageBus)
    {}

    public function handle(Query $query): mixed
    {
        try {
            return $this->handleQuery($query);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }
            throw $e;
        }
    }
}
