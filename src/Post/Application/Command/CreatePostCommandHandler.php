<?php

namespace App\Post\Application\Command;

use App\Post\Domain\Post;
use App\Post\Domain\Repository\PostRepository;
use App\User\Domain\Service\UserFinderService;
use Lib\CQRS\CommandHandler;
use Lib\CQRS\EventBus;

class CreatePostCommandHandler implements CommandHandler
{
    public function __construct(private PostRepository $postRepository, private UserFinderService $userFinderService, private EventBus $eventBus)
    {}

    public function __invoke(CreatePostCommand $command): void
    {
        $author = $this->userFinderService->findOrFail($command->authorId());

        $post = Post::create(
            $command->postId(),
            $command->title(),
            $command->body(),
            $author
        );

        $this->postRepository->create($post);

        $this->eventBus->dispatch(...$post->pullDomainEvents());
    }
}
