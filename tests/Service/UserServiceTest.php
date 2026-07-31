<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginRequest;
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

    private function createUser(): void
    {
        $user = new User();
        $user->name = "Administrator";
        $user->email = "admin@test.com";
        $user->password = password_hash("password", PASSWORD_BCRYPT);
        $user->avatar = "avatar.png";
        $user->position = "Administrator";
        $user->role = "admin";

        $this->userRepository->save($user);
    }

    public function testLoginSuccess()
    {
        $this->createUser();

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
        $this->createUser();

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
}
