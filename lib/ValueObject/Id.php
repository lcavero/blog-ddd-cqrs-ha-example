<?php

namespace Lib\ValueObject;

use Exception;
use Lib\ValueObject\Exception\InvalidIdException;
use Symfony\Component\Uid\Uuid;

class Id
{
    private Uuid $id;

    private function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
    }

    public static function fromString(string $id): static
    {
        try {
            return new static($id);
        } catch (Exception $e) {
            throw InvalidIdException::create(sprintf('Invalid identifier %s received', $id), $e);
        }
    }

    public static function fromId(Id $id): static
    {
        return new static($id->toString());
    }

    public function value(): Uuid
    {
        return $this->id;
    }

    public function toString(): string
    {
        return $this->id->toBase32();
    }

    public function equals(Id $id): bool
    {
        return $this->id === $id->value();
    }
}
