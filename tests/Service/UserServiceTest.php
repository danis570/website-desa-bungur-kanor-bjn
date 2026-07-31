<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();

        $this->userService = new UserService($this->userRepository);
    }

    public function testCreateSuccess()
    {
        $request = new UserCreateRequest();
        $request->name = "Administrator";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";
        $request->avatar = "avatar.png";

        $response = $this->userService->create($request);

        $this->assertNotNull($response->user->id);
        $this->assertEquals("Administrator", $response->user->name);
        $this->assertEquals("admin@test.com", $response->user->email);
        $this->assertEquals("Administrator", $response->user->position);
        $this->assertEquals("admin", $response->user->role);
        $this->assertEquals("avatar.png", $response->user->avatar);

        $this->assertTrue(
            password_verify(
                "password",
                $response->user->password
            )
        );
    }

    public function testCreateDuplicateEmail()
    {
        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);

        $this->expectException(ValidationException::class);

        $this->userService->create($request);
    }

    public function testCreateEmptyName()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);
    }

    public function testCreateEmptyEmail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);
    }

    public function testCreateInvalidEmail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);
    }

    public function testCreateEmptyPassword()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);
    }

    public function testCreatePasswordTooShort()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "123";
        $request->position = "Administrator";
        $request->role = "admin";

        $this->userService->create($request);
    }

    public function testCreateEmptyRole()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "";

        $this->userService->create($request);
    }

    public function testCreateInvalidRole()
    {
        $this->expectException(ValidationException::class);

        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "superadmin";

        $this->userService->create($request);
    }

    public function testCreateUserRoleSuccess()
    {
        $request = new UserCreateRequest();
        $request->name = "User";
        $request->email = "user@test.com";
        $request->password = "password";
        $request->position = "Operator";
        $request->role = "user";

        $response = $this->userService->create($request);

        $this->assertEquals("user", $response->user->role);
    }

    public function testCreateAdminRoleSuccess()
    {
        $request = new UserCreateRequest();
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->password = "password";
        $request->position = "Administrator";
        $request->role = "admin";

        $response = $this->userService->create($request);

        $this->assertEquals("admin", $response->user->role);
    }

    private function createUser(
        string $name,
        string $email,
        string $position,
        string $role
    ): User {

        $user = new User();

        $user->name = $name;
        $user->email = $email;
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->avatar = "avatar.png";
        $user->position = $position;
        $user->role = $role;

        return $this->userRepository->save($user);
    }

    public function testLoginSuccess()
    {
        $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $request = new UserLoginRequest();
        $request->email = "admin@test.com";
        $request->password = "password";

        $response = $this->userService->login($request);

        $this->assertEquals("Administrator", $response->user->name);
        $this->assertEquals("admin@test.com", $response->user->email);
        $this->assertEquals("admin", $response->user->role);
    }

    public function testLoginEmailNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "notfound@test.com";
        $request->password = "password";

        $this->userService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "admin@test.com";
        $request->password = "salah";

        $this->userService->login($request);
    }

    public function testLoginEmptyEmail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "";
        $request->password = "password";

        $this->userService->login($request);
    }

    public function testLoginEmptyPassword()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "admin@test.com";
        $request->password = "";

        $this->userService->login($request);
    }

    public function testLoginInvalidEmail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "admin";
        $request->password = "password";

        $this->userService->login($request);
    }

    public function testLoginNullEmail()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = null;
        $request->password = "password";

        $this->userService->login($request);
    }

    public function testLoginNullPassword()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->email = "admin@test.com";
        $request->password = null;

        $this->userService->login($request);
    }

    public function testFindAllEmpty(): void
    {
        $users = $this->userService->findAll();

        $this->assertCount(0, $users);
    }

    public function testFindAllSuccess(): void
    {
        $admin = $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $operator = $this->createUser(
            "Operator",
            "operator@test.com",
            "Operator",
            "user"
        );

        $users = $this->userService->findAll();

        $this->assertCount(2, $users);

        // Operator dibuat terakhir
        $this->assertEquals($operator->id, $users[0]->id);
        $this->assertEquals("Operator", $users[0]->name);
        $this->assertEquals("operator@test.com", $users[0]->email);
        $this->assertEquals("user", $users[0]->role);

        // Administrator dibuat pertama
        $this->assertEquals($admin->id, $users[1]->id);
        $this->assertEquals("Administrator", $users[1]->name);
        $this->assertEquals("admin@test.com", $users[1]->email);
        $this->assertEquals("admin", $users[1]->role);
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

        $request = new UserUpdateRequest();
        $request->id = $user->id;
        $request->name = "Administrator Baru";
        $request->email = "adminbaru@test.com";
        $request->password = "";
        $request->position = "Ketua";
        $request->role = "admin";

        $response = $this->userService->update($request);

        $this->assertEquals($user->id, $response->user->id);
        $this->assertEquals("Administrator Baru", $response->user->name);
        $this->assertEquals("adminbaru@test.com", $response->user->email);
        $this->assertEquals("Ketua", $response->user->position);
        $this->assertEquals("admin", $response->user->role);
    }

    public function testUpdatePassword(): void
    {
        $user = $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $user = $this->userRepository->findByEmail("admin@test.com");

        $request = new UserUpdateRequest();
        $request->id = $user->id;
        $request->name = $user->name;
        $request->email = $user->email;
        $request->password = "passwordbaru";
        $request->position = $user->position;
        $request->role = $user->role;

        $response = $this->userService->update($request);

        $this->assertTrue(
            password_verify(
                "passwordbaru",
                $response->user->password
            )
        );
    }

    public function testUpdateAvatar(): void
    {
        $user = $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $user = $this->userRepository->findByEmail("admin@test.com");

        $request = new UserUpdateRequest();
        $request->id = $user->id;
        $request->name = $user->name;
        $request->email = $user->email;
        $request->password = "";
        $request->position = $user->position;
        $request->role = $user->role;
        $request->avatar = "avatarbaru.png";

        $response = $this->userService->update($request);

        $this->assertEquals(
            "avatarbaru.png",
            $response->user->avatar
        );
    }

    public function testUpdateUserNotFound(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = 9999;
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->role = "admin";

        $this->userService->update($request);
    }

    public function testUpdateDuplicateEmail(): void
    {
        $admin = new User();
        $admin->name = "Admin";
        $admin->email = "admin@test.com";
        $admin->password = password_hash("password", PASSWORD_BCRYPT);
        $admin->role = "admin";

        $admin = $this->userRepository->save($admin);

        $user = new User();
        $user->name = "User";
        $user->email = "user@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->role = "user";

        $user = $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = $user->id;
        $request->name = "User";
        $request->email = "admin@test.com";
        $request->password = "";
        $request->position = "";
        $request->role = "user";

        $this->userService->update($request);
    }

    public function testUpdateInvalidEmail(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = 1;
        $request->name = "Admin";
        $request->email = "admin";
        $request->role = "admin";

        $this->userService->update($request);
    }

    public function testUpdateEmptyName(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = 1;
        $request->name = "";
        $request->email = "admin@test.com";
        $request->role = "admin";

        $this->userService->update($request);
    }

    public function testUpdateInvalidRole(): void
    {
        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = 1;
        $request->name = "Admin";
        $request->email = "admin@test.com";
        $request->role = "superadmin";

        $this->userService->update($request);
    }

    public function testUpdatePasswordTooShort(): void
    {
        $user = $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $user = $this->userRepository->findByEmail("admin@test.com");

        $this->expectException(ValidationException::class);

        $request = new UserUpdateRequest();
        $request->id = $user->id;
        $request->name = $user->name;
        $request->email = $user->email;
        $request->password = "123";
        $request->position = $user->position;
        $request->role = $user->role;

        $this->userService->update($request);
    }

    public function testFindByIdSuccess(): void
    {
        $user = $this->createUser(
            "Administrator",
            "admin@test.com",
            "Administrator",
            "admin"
        );

        $result = $this->userService->findById($user->id);

        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->name, $result->name);
        $this->assertEquals($user->email, $result->email);
    }

    public function testFindByIdNotFound(): void
{
    $this->expectException(ValidationException::class);

    $this->userService->findById(9999);
}
}
