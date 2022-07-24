<?php

namespace App\Post\Domain;

use App\Post\Domain\Event\PostWasCreatedEvent;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Event\DomainEventsRecorderTrait;
use App\Shared\Domain\Validation\DomainValidationTrait;
use App\User\Domain\User;
use Symfony\Component\Validator\Constraints as Assert;

class Post implements AggregateRoot
{
    use DomainEventsRecorderTrait;
    use DomainValidationTrait;

    private string $id;
    private string $title;
    private string $body;
    private User $author;

    private function __construct(PostId $postId, string $title, string $body, User $author)
    {
        $this->validate(['title' => $title, 'body' => $body], $this->validationConstraints());

        $this->id = $postId->toString();
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
    }

    private function validationConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'title' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255])
            ],
            'body' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 1000])
            ]
        ]);
    }

    public static function create(PostId $postId, string $title, string $body, User $author): self
    {
        $post = new static($postId, $title, $body, $author);
        $post->record(PostWasCreatedEvent::fromPost($post));
        return $post;
    }

    public function id(): PostId
    {
        return PostId::fromString($this->id);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function author(): User
    {
        return $this->author;
    }
}
