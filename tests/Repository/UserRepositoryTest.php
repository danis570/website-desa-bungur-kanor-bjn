<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }
    public function testSaveSuccess(): void
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->position = "Administrator";
        $user->role = "admin";

        $result = $this->userRepository->save($user);

        $this->assertNotNull($result->id);

        $savedUser = $this->userRepository->findById($result->id);

        $this->assertNotNull($savedUser);
        $this->assertEquals("Admin", $savedUser->name);
        $this->assertEquals("admin@test.com", $savedUser->email);
        $this->assertEquals("Administrator", $savedUser->position);
        $this->assertEquals("admin", $savedUser->role);
    }

    public function testFindByIdNotFound(): void
    {
        $user = $this->userRepository->findById(99999);

        $this->assertNull($user);
    }

    public function testFindByEmailSuccess(): void
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->position = "Administrator";
        $user->role = "admin";

        $this->userRepository->save($user);

        $result = $this->userRepository->findByEmail("admin@test.com");

        $this->assertNotNull($result);
        $this->assertEquals("Admin", $result->name);
        $this->assertEquals("admin@test.com", $result->email);
        $this->assertEquals("Administrator", $result->position);
        $this->assertEquals("admin", $result->role);
    }

    public function testFindByEmailNotFound(): void
    {
        $result = $this->userRepository->findByEmail("notfound@test.com");

        $this->assertNull($result);
    }

}
