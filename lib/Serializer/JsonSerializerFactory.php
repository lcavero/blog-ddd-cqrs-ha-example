<?php

namespace Lib\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonSerializerFactory implements SerializerFactory
{
    public function create(): SerializerInterface
    {
        $normalizers = [new PropertyNormalizer()];
        $encoders = [new JsonEncoder()];
        return new Serializer($normalizers, $encoders);
    }
}
