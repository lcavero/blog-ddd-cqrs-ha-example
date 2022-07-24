<?php

namespace App\Post\Application\Query;

use App\Post\Domain\Post;

class GetPostsQueryResponse
{
    private function __construct(private string $id, private string $title, private string $authorId)
    {}

    public static function fromEntity(Post $post): self
    {
        return new static($post->id()->toString(), $post->title(), $post->author()->id()->toString());
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}
