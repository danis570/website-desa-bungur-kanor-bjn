<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Session;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
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

    public function testSaveSuccess()
    {
        $user = $this->createUser();

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        $this->assertNotNull($result);
        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($user->id, $result->userId);
    }

    public function testFindByIdSuccess()
    {
        $user = $this->createUser();

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);

        $this->assertNotNull($result);
        $this->assertEquals($session->id, $result->id);
        $this->assertEquals($user->id, $result->userId);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById("tidak-ada");

        $this->assertNull($result);
    }

    public function testDeleteById()
    {
        $user = $this->createUser();

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;

        $this->sessionRepository->save($session);

        $this->sessionRepository->deleteById($session->id);

        $this->assertNull(
            $this->sessionRepository->findById($session->id)
        );
    }


}
