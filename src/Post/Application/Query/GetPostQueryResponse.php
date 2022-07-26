<?php

namespace App\Post\Application\Query;

use App\Post\Domain\Post;

class GetPostQueryResponse
{
    private function __construct(private string $id, private string $title, private string $body, private array $author)
    {}

    public static function fromEntity(Post $post): self
    {
        $author = [
            'id' => $post->author()->id()->toString(),
            'username' => $post->author()->username(),
            'email' => $post->author()->email(),
            'website' => $post->author()->website()
        ];

        return new static($post->id()->toString(), $post->title(), $post->body(), $author);
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

    public function author(): array
    {
        return $this->author;
    }
}
