<?php

namespace App\Post\Application\Command;

use App\Post\Domain\PostId;
use App\Post\Domain\Specification\PostAuthorIdSpecification;
use App\Post\Domain\Specification\PostBodySpecification;
use App\Post\Domain\Specification\PostTitleSpecification;
use App\Shared\Application\Exception\ApplicationValidationException;
use App\User\Domain\UserId;
use Lib\CQRS\Command;
use Lib\Validation\ValidationContext;
use Lib\ValueObject\Id;

class CreatePostCommand implements Command
{
    private ValidationContext $context;

    private PostId $postId;
    private string $title;
    private string $body;
    private UserId $authorId;

    private function __construct(Id $postId, array $payload)
    {
        $this->context = ValidationContext::create();

        $this->setPostId($postId);
        $this->setTitle($payload['title'] ?? null);
        $this->setBody($payload['body'] ?? null);
        $this->setAuthorId($payload['authorId'] ?? null);

        if ($this->context->hasErrors()) {
            throw ApplicationValidationException::fromViolations($this->context->errors());
        }
    }

    public static function create(Id $postId, array $payload): self
    {
        return new static($postId, $payload);
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    private function setPostId(Id $postId): void
    {
        $this->postId = PostId::fromId($postId);
    }

    public function title(): string
    {
        return $this->title;
    }

    private function setTitle(?string $title): void
    {
        $specification = new PostTitleSpecification();
        if ($specification->isSatisfiedBy($title, $this->context)) {
            $this->title = $title;
        }
    }

    public function body(): string
    {
        return $this->body;
    }

    private function setBody(?string $body): void
    {
        $specification = new PostBodySpecification();
        if ($specification->isSatisfiedBy($body, $this->context)) {
            $this->body = $body;
        }
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function setAuthorId(?string $authorId): void
    {
        $specification = new PostAuthorIdSpecification();
        if ($specification->isSatisfiedBy($authorId, $this->context)) {
            $this->authorId = UserId::fromString($authorId);
        }
    }
}
