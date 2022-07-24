<?php

namespace App\Post\Infrastructure\Repository;

use App\Post\Domain\Post;
use App\Post\Domain\PostId;
use App\Post\Domain\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostORMRepository extends ServiceEntityRepository implements PostRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findOne(PostId $postId): ?Post
    {
       return $this->find($postId->toString());
    }

    public function create(Post $post): void
    {
        $this->getEntityManager()->persist($post);
    }

    public function update(Post $post): void
    {
        // Unnecessary implementation
    }
}
