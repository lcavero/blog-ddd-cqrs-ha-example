<?php

namespace Lib\CQRS;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
