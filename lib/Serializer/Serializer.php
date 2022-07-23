<?php

namespace Lib\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

class Serializer implements SerializerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerFactory $serializerFactory)
    {
        $this->serializer = $serializerFactory->create();
    }

    public function serialize(mixed $data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
