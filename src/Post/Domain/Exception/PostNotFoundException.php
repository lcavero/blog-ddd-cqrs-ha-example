<?php

namespace App\Post\Domain\Exception;

use App\Post\Domain\PostId;
use App\Shared\Domain\Exception\DomainException;

class PostNotFoundException extends DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function fromPostId(PostId $postId): self
    {
        return new static(sprintf('The Post with id %s was not found', $postId->toString()));
    }
}
