<?php

namespace App\Post\Application\Command;

use App\Post\Domain\PostId;
use App\Shared\Application\Validation\ApplicationValidationTrait;
use App\User\Domain\User;
use Lib\CQRS\Command;
use Lib\ValueObject\Id;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePostCommand implements Command
{
    use ApplicationValidationTrait;

    private PostId $postId;
    private string $title;
    private string $body;
    private User $author;

    private function __construct(Id $postId, array $payload)
    {
        $this->validate($payload, $this->validationConstrains());

        $this->postId = PostId::fromId($postId);
        $this->title = $payload['title'];
        $this->body = $payload['body'];
        $this->author = $payload['author'];
    }

    public static function create(Id $postId, array $payload): self
    {
        return new static($postId, $payload);
    }

    private function validationConstrains() : Assert\Collection
    {
        return new Assert\Collection([
            'title' => [
                new Assert\NotBlank(),
            ],
            'body' => [
                new Assert\NotBlank(),
            ],
            'author' => [
                new Assert\NotBlank(),
                new Assert\Type(User::class)
            ]
        ]);
    }

    public function postId(): PostId
    {
        return $this->postId;
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
