<?php

namespace Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;
    private SessionService $sessionService;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $this->sessionService = new SessionService(
            $this->sessionRepository,
            $this->userRepository
        );
    }

    private function createUser(): User
    {
        $user = new User();
        $user->name = "Administrator";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->avatar = "avatar.png";
        $user->position = "Administrator";
        $user->role = "admin";

        return $this->userRepository->save($user);
    }

    public function testCreateSuccess()
    {
        $user = $this->createUser();

        $session = $this->sessionService->create($user->id);

        $this->assertNotNull($session->id);
        $this->assertEquals($user->id, $session->userId);

        $result = $this->sessionRepository->findById($session->id);

        $this->assertNotNull($result);
        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($user->id, $result->userId);
    }

    public function testCurrentSuccess(): void
{
    $user = $this->createUser();

    $session = $this->sessionService->create($user->id);

    $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

    $current = $this->sessionService->current();

    $this->assertNotNull($current);

    $this->assertEquals($user->id, $current->id);
    $this->assertEquals($user->email, $current->email);
    $this->assertEquals($user->role, $current->role);
}

    public function testCurrentNotFound()
    {
        $current = $this->sessionService->current("session-tidak-ada");

        $this->assertNull($current);
    }

public function testDestroySuccess(): void
{
    $user = $this->createUser();

    $session = $this->sessionService->create($user->id);

    $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

    $this->sessionService->destroy();

    $result = $this->sessionRepository->findById($session->id);

    $this->assertNull($result);
}
}