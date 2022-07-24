<?php

namespace App\Tests\Post\Domain;

use App\Post\Domain\Event\PostWasCreatedEvent;
use App\Post\Domain\Post;
use App\Shared\Domain\Exception\DomainValidationException;
use App\Tests\Lib\Event\DomainEventTester;
use App\Tests\Lib\Validation\DomainValidationExceptionTester;
use App\Tests\Post\Domain\Mock\PostIdMother;
use App\Tests\User\Domain\Mock\UserMother;
use Lib\Random\RandomStringGenerator;
use PHPUnit\Framework\TestCase;

class CreatePostTest extends TestCase
{
    const TITLE_MAX_LENGTH = 255;
    const BODY_MAX_LENGTH = 1000;

    public function testPostIsCreatedWithNormalData() : void
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
        try {
            $postId = PostIdMother::random();
            $author = UserMother::one();
            $title = '';
            $body = 'Body';

            Post::create($postId, $title, $body, $author);
            $this->fail('DomainValidationException was not thrown');
        } catch (DomainValidationException $e) {
            $this->assertTrue(
                DomainValidationExceptionTester::exceptionHasError(
                    $e,
                    'title',
                    'This value should not be blank.'
                ),
                'Blank title error message was not found');
        }
    }

    public function testPostIsNotCreatedWithOverlongTitle(): void
    {
        try {
            $postId = PostIdMother::random();
            $author = UserMother::one();
            $title = RandomStringGenerator::generate(self::TITLE_MAX_LENGTH + 1);
            $body = 'Body';

            Post::create($postId, $title, $body, $author);
            $this->fail('DomainValidationException was not thrown');
        } catch (DomainValidationException $e) {
            $this->assertTrue(
                DomainValidationExceptionTester::exceptionHasError(
                    $e,
                    'title',
                    sprintf('This value is too long. It should have %d characters or less.', self::TITLE_MAX_LENGTH)
                ),
                'Overlong title error message was not found');
        }
    }

    public function testPostIsNotCreatedWithEmptyBody(): void
    {
        try {
            $postId = PostIdMother::random();
            $author = UserMother::one();
            $title = 'Title';
            $body = '';

            Post::create($postId, $title, $body, $author);
            $this->fail('DomainValidationException was not thrown');
        } catch (DomainValidationException $e) {
            $this->assertTrue(DomainValidationExceptionTester::exceptionHasError($e, 'body', 'This value should not be blank.'), 'Blank body error message was not found');
        }
    }

    public function testPostIsNotCreatedWithOverlongBody(): void
    {
        try {
            $postId = PostIdMother::random();
            $author = UserMother::one();
            $title = 'Title';
            $body = RandomStringGenerator::generate(self::BODY_MAX_LENGTH + 1);;

            Post::create($postId, $title, $body, $author);
            $this->fail('DomainValidationException was not thrown');
        } catch (DomainValidationException $e) {
            $this->assertTrue(
                DomainValidationExceptionTester::exceptionHasError(
                    $e,
                    'body',
                    sprintf('This value is too long. It should have %d characters or less.', self::BODY_MAX_LENGTH)
                ),
                'Overlong body error message was not found');
        }
    }
}
