<?php

namespace App\Post\Application\Command;

use App\Post\Domain\Post;
use App\Post\Domain\Repository\PostRepository;
use Lib\CQRS\CommandHandler;
use Lib\CQRS\EventBus;

class CreatePostCommandHandler implements CommandHandler
{
    public function __construct(private PostRepository $repository, private EventBus $eventBus)
    {}

    public function __invoke(CreatePostCommand $command): void
    {
        $post = Post::create(
            $command->postId(),
            $command->title(),
            $command->body(),
            $command->author()
        );

        $this->repository->create($post);

        $this->eventBus->dispatch(...$post->pullDomainEvents());
    }
}
