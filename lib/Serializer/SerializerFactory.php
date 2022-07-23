<?php

namespace Lib\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

interface SerializerFactory
{
    public function create(): SerializerInterface;
}
