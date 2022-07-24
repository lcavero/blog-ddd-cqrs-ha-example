<?php

namespace App\Post\Application\Query;

use App\Post\Domain\PostId;
use Lib\CQRS\Query;
use Lib\ValueObject\Id;

class GetPostQuery implements Query
{
    private PostId $postId;

    private function __construct(Id $postId)
    {
        $this->postId = PostId::fromId($postId);
    }

    public static function create(Id $postId): self
    {
        return new static($postId);
    }

    public function postId(): PostId
    {
        return $this->postId;
    }
}
