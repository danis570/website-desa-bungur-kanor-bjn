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

    public function testFindAllEmpty(): void
    {

        $users = $this->userRepository->findAll();



        $this->assertCount(0, $users);

    }


    public function testFindAllIgnoreDeletedUser(): void
    {
        $user1 = new User();
        $user1->name = "Admin";
        $user1->email = "admin@test.com";
        $user1->password = password_hash("password", PASSWORD_BCRYPT);
        $user1->position = "Administrator";
        $user1->role = "admin";

        $user1 = $this->userRepository->save($user1);

        $user2 = new User();
        $user2->name = "Operator";
        $user2->email = "operator@test.com";
        $user2->password = password_hash("password", PASSWORD_BCRYPT);
        $user2->position = "Operator";
        $user2->role = "user";

        $user2 = $this->userRepository->save($user2);

        // Soft delete user kedua
        $this->userRepository->softDelete($user2->id);

        $users = $this->userRepository->findAll();

        $this->assertCount(1, $users);
        $this->assertEquals($user1->id, $users[0]->id);
    }

    public function testFindAllSuccess(): void
    {
        $user1 = new User();

        $user1->name = "Admin";
        $user1->email = "admin@test.com";
        $user1->password = password_hash("password", PASSWORD_BCRYPT);
        $user1->position = "Administrator";
        $user1->role = "admin";

        $this->userRepository->save($user1);

        $user2 = new User();

        $user2->name = "Operator";
        $user2->email = "operator@test.com";
        $user2->password = password_hash("password", PASSWORD_BCRYPT);
        $user2->position = "Operator";
        $user2->role = "user";

        $this->userRepository->save($user2);



        $users = $this->userRepository->findAll();



        $this->assertCount(2, $users);



        // terbaru berada di atas
        $this->assertEquals("Operator", $users[0]->name);
        $this->assertEquals("operator@test.com", $users[0]->email);



        $this->assertEquals("Admin", $users[1]->name);
        $this->assertEquals("admin@test.com", $users[1]->email);
    }

    public function testUpdateSuccess(): void
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->position = "Administrator";
        $user->role = "admin";

        $user = $this->userRepository->save($user);

        $user->name = "Administrator Baru";
        $user->email = "baru@test.com";
        $user->position = "Kepala Desa";
        $user->role = "user";

        $this->userRepository->update($user);

        $updated = $this->userRepository->findById($user->id);

        $this->assertNotNull($updated);
        $this->assertEquals("Administrator Baru", $updated->name);
        $this->assertEquals("baru@test.com", $updated->email);
        $this->assertEquals("Kepala Desa", $updated->position);
        $this->assertEquals("user", $updated->role);
    }

    public function testUpdatePassword(): void
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->position = "Administrator";
        $user->role = "admin";

        $user = $this->userRepository->save($user);

        $user->password = password_hash("passwordbaru", PASSWORD_BCRYPT);

        $this->userRepository->update($user);

        $updated = $this->userRepository->findById($user->id);

        $this->assertTrue(
            password_verify("passwordbaru", $updated->password)
        );
    }

    public function testUpdateAvatar(): void
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->position = "Administrator";
        $user->role = "admin";
        $user->avatar = "lama.png";

        $user = $this->userRepository->save($user);

        $user->avatar = "baru.png";

        $this->userRepository->update($user);

        $updated = $this->userRepository->findById($user->id);

        $this->assertEquals("baru.png", $updated->avatar);
    }

    public function testUpdateNotFound(): void
    {
        $user = new User();
        $user->id = 99999;
        $user->name = "Admin";
        $user->email = "admin@test.com";
        $user->password = "password";
        $user->position = "Administrator";
        $user->role = "admin";

        $this->userRepository->update($user);

        $result = $this->userRepository->findById(99999);

        $this->assertNull($result);
    }

}
