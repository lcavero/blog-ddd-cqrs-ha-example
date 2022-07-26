<?php

namespace App\Tests\Post\Domain;

use App\Post\Domain\Event\PostWasCreatedEvent;
use App\Post\Domain\Exception\InvalidPostBodyException;
use App\Post\Domain\Exception\InvalidPostTitleException;
use App\Post\Domain\Post;
use App\Tests\Lib\Event\DomainEventTester;
use App\Tests\Post\Domain\Mock\PostIdMother;
use App\Tests\User\Domain\Mock\UserMother;
use Lib\Random\RandomStringGenerator;
use PHPUnit\Framework\TestCase;

class CreatePostTest extends TestCase
{
    const TITLE_MAX_LENGTH = 255;
    const BODY_MAX_LENGTH = 1000;

    public function testPostIsCreatedWithNormalData(): void
    {
        $postId = PostIdMother::random();
        $author = UserMother::one();
        $title = 'Títle';
        $body = 'Body';

        $post = Post::create($postId, $title, $body, $author);
        $this->assertInstanceOf(Post::class, $post);
        $this->assertSame($title, $post->title());
        $this->assertSame($body, $post->body());
        $this->assertSame($author, $post->author());

        $this->assertTrue(
            DomainEventTester::domainEventWasCreated($post,PostWasCreatedEvent::class),
            'PostWasCreatedEvent event was not created'
        );
    }

    public function testPostIsNotCreatedWithEmptyTitle(): void
    {
        $postId = PostIdMother::random();
        $author = UserMother::one();
        $title = '';
        $body = 'Body';

        $this->expectException(InvalidPostTitleException::class);
        Post::create($postId, $title, $body, $author);
    }

    public function testPostIsNotCreatedWithOverlongTitle(): void
    {
        $postId = PostIdMother::random();
        $author = UserMother::one();
        $title = RandomStringGenerator::generate(self::TITLE_MAX_LENGTH + 1);
        $body = 'Body';
        $this->expectException(InvalidPostTitleException::class);
        Post::create($postId, $title, $body, $author);
    }

    public function testPostIsNotCreatedWithEmptyBody(): void
    {
        $postId = PostIdMother::random();
        $author = UserMother::one();
        $title = 'Title';
        $body = '';
        $this->expectException(InvalidPostBodyException::class);
        Post::create($postId, $title, $body, $author);
    }

    public function testPostIsNotCreatedWithOverlongBody(): void
    {
        $postId = PostIdMother::random();
        $author = UserMother::one();
        $title = 'Title';
        $body = RandomStringGenerator::generate(self::BODY_MAX_LENGTH + 1);;
        $this->expectException(InvalidPostBodyException::class);
        Post::create($postId, $title, $body, $author);
    }
}
