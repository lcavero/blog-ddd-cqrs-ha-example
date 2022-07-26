<?php

namespace App\Post\Domain;

use App\Post\Domain\Event\PostWasCreatedEvent;
use App\Post\Domain\Exception\InvalidPostBodyException;
use App\Post\Domain\Exception\InvalidPostTitleException;
use App\Post\Domain\Specification\PostBodySpecification;
use App\Post\Domain\Specification\PostTitleSpecification;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Event\DomainEventsRecorderTrait;
use App\User\Domain\User;

class Post implements AggregateRoot
{
    use DomainEventsRecorderTrait;

    private string $id;
    private string $title;
    private string $body;
    private User $author;

    private function __construct(PostId $postId, string $title, string $body, User $author)
    {
        $this->setId($postId);
        $this->setTitle($title);
        $this->setBody($body);
        $this->author = $author;
    }

    public static function create(PostId $postId, string $title, string $body, User $author): self
    {
        $post = new static($postId, $title, $body, $author);
        $post->record(PostWasCreatedEvent::fromEntity($post));
        return $post;
    }

    public function id(): PostId
    {
        return PostId::fromString($this->id);
    }

    private function setId(PostId $postId): void
    {
        $this->id = $postId->toString();
    }

    public function title(): string
    {
        return $this->title;
    }

    private function setTitle(string $title): void
    {
        $specification = new PostTitleSpecification();
        if (!$specification->isSatisfiedBy($title)) {
            throw InvalidPostTitleException::fromTitle($title);
        }
        $this->title = $title;
    }

    public function body(): string
    {
        return $this->body;
    }

    private function setBody(string $body): void
    {
        $specification = new PostBodySpecification();
        if (!$specification->isSatisfiedBy($body)) {
            throw InvalidPostBodyException::fromBody($body);
        }
        $this->body = $body;
    }

    public function author(): User
    {
        return $this->author;
    }
}
