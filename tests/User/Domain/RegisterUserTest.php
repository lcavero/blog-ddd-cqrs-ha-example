<?php

namespace App\Tests\User\Domain;

use App\Tests\Lib\Event\DomainEventTester;
use App\Tests\User\Domain\Mock\UserIdMother;
use App\User\Domain\Event\UserWasRegisteredEvent;
use App\User\Domain\Exception\InvalidUserEmailException;
use App\User\Domain\Exception\InvalidUserEncryptedPasswordException;
use App\User\Domain\Exception\InvalidUserPhoneException;
use App\User\Domain\Exception\InvalidUserUsernameException;
use App\User\Domain\Exception\InvalidUserWebsiteException;
use App\User\Domain\User;
use Lib\Random\RandomStringGenerator;
use PHPUnit\Framework\TestCase;

class RegisterUserTest extends TestCase
{
    const USERNAME_MAX_LENGTH = 255;
    const EMAIL_MAX_LENGTH = 255;
    const ENCODED_PASSWORD_MAX_LENGTH = 255;
    const PHONE_MAX_LENGTH = 20;
    const WEBSITE_MAX_LENGTH = 255;

    public function testUserIsCreatedWithNormalData(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = '666666666';
        $website = 'https://test.com';

        $user = User::register($userId, $username, $password, $email, $phone, $website);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($username, $user->username());
        $this->assertSame($password, $user->password());
        $this->assertSame($email, $user->email());
        $this->assertSame($phone, $user->phone());
        $this->assertSame($website, $user->website());

        $this->assertTrue(
            DomainEventTester::domainEventWasCreated($user,UserWasRegisteredEvent::class),
            'UserWasRegistered event was not created'
        );
    }

    public function testUserIsCreatedWithoutOptionalData(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';

        $user = User::register($userId, $username, $password, $email, null, null);

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($username, $user->username());
        $this->assertSame($password, $user->password());
        $this->assertSame($email, $user->email());
        $this->assertNull($user->phone());
        $this->assertNull($user->website());

        $this->assertTrue(
            DomainEventTester::domainEventWasCreated($user,UserWasRegisteredEvent::class),
            'UserWasRegistered event was not created'
        );
    }

    public function testUserIsNotCreatedWithEmptyUsername(): void
    {
        $userId = UserIdMother::random();
        $username = '';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';

        $this->expectException(InvalidUserUsernameException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithOverlongUsername(): void
    {
        $userId = UserIdMother::random();
        $username = RandomStringGenerator::generate(self::USERNAME_MAX_LENGTH + 1);
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';

        $this->expectException(InvalidUserUsernameException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithEmptyEncryptedPassword(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = '';
        $email = 'test@test.com';

        $this->expectException(InvalidUserEncryptedPasswordException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithOverlongEncryptedPassword(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = RandomStringGenerator::generate(self::ENCODED_PASSWORD_MAX_LENGTH + 1);
        $email = 'test@test.com';

        $this->expectException(InvalidUserEncryptedPasswordException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithEmptyEmail(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = '';

        $this->expectException(InvalidUserEmailException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithOverlongEmail(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = sprintf('a@%s.com', RandomStringGenerator::generate( self::EMAIL_MAX_LENGTH - 6));

        $this->expectException(InvalidUserEmailException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithInvalidEmail(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'invalid-email';

        $this->expectException(InvalidUserEmailException::class);
        User::register($userId, $username, $password, $email, null, null);
    }

    public function testUserIsNotCreatedWithEmptyPhone(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = '';

        $this->expectException(InvalidUserPhoneException::class);
        User::register($userId, $username, $password, $email, $phone, null);
    }

    public function testUserIsNotCreatedWithOverlongPhone(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = RandomStringGenerator::generate(self::PHONE_MAX_LENGTH + 1);

        $this->expectException(InvalidUserPhoneException::class);
        User::register($userId, $username, $password, $email, $phone, null);
    }

    public function testUserIsNotCreatedWithInvalidPhone(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = 'invalid-phone';

        $this->expectException(InvalidUserPhoneException::class);
        User::register($userId, $username, $password, $email, $phone, null);
    }

    public function testUserIsNotCreatedWithEmptyWebsite(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = '666666666';
        $website = '';

        $this->expectException(InvalidUserWebsiteException::class);
        User::register($userId, $username, $password, $email, $phone, $website);
    }

    public function testUserIsNotCreatedWithOverlongWebsite(): void
    {
        $userId = UserIdMother::random();
        $username = 'test';
        $password = 'a-fake-encoded-password';
        $email = 'test@test.com';
        $phone = '666666666';
        $website = RandomStringGenerator::generate(self::WEBSITE_MAX_LENGTH + 1);

        $this->expectException(InvalidUserWebsiteException::class);
        User::register($userId, $username, $password, $email, $phone, $website);
    }
}
