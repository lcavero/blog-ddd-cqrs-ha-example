<?php

namespace Lib\CQRS;

interface CommandBus
{
    public function dispatch(Command $command): void;
}
