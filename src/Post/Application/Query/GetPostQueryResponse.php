<?php

namespace App\Post\Application\Query;

use App\Post\Domain\Post;

class GetPostQueryResponse
{
    private function __construct(private string $id, private string $title, private string $body, private string $authorId)
    {}

    public static function fromEntity(Post $post): self
    {
        return new static($post->id()->toString(), $post->title(), $post->body(), $post->author()->id()->toString());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}
