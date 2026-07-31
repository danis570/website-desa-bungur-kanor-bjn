<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Exception;
use Kkn27Unirow\WebsiteDesaBungur\App\Auth;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserCreateResponse;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginResponse;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserUpdateResponse;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(UserCreateRequest $request): UserCreateResponse
    {
        $this->validationCreate($request);

        try {
            Database::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->avatar = $request->avatar;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->position = $request->position;
            $user->role = $request->role;

            $user = $this->userRepository->save($user);

            Database::commitTransaction();

            $response = new UserCreateResponse();
            $response->user = $user;

            return $response;
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validationCreate(UserCreateRequest $request): void
    {
        if (
            $request->name === null || trim($request->name) === '' ||
            $request->email === null || trim($request->email) === '' ||
            $request->password === null || trim($request->password) === '' ||
            $request->role === null || trim($request->role) === ''
        ) {
            throw new ValidationException("Semua field wajib diisi.");
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Format email tidak valid.");
        }

        if (strlen($request->password) < 8) {
            throw new ValidationException("Password minimal 8 karakter.");
        }

        $user = $this->userRepository->findByEmail($request->email);

        if ($user !== null) {
            throw new ValidationException("Email sudah digunakan.");
        }

        if (!in_array($request->role, ['admin', 'user'])) {
            throw new ValidationException("Role tidak valid.");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {
        $this->validationLogin($request);

        $user = $this->userRepository->findByEmail($request->email);

        if ($user == null) {
            throw new ValidationException("Email atau password salah.");
        }

        if (!password_verify($request->password, $user->password)) {
            throw new ValidationException("Email atau password salah.");
        }

        $response = new UserLoginResponse();
        $response->user = $user;

        return $response;
    }
    private function validationLogin(UserLoginRequest $request): void
    {
        if (
            $request->email == null || trim($request->email) == "" ||
            $request->password == null || trim($request->password) == ""
        ) {
            throw new ValidationException("Email dan password wajib diisi.");
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Format email tidak valid.");
        }
    }

    public function update(UserUpdateRequest $request): UserUpdateResponse
    {
        $this->validateUpdateRequest($request);

        $user = $this->userRepository->findById($request->id);

        if ($user == null) {
            throw new ValidationException("User tidak ditemukan");
        }

        $emailOwner = $this->userRepository->findByEmail($request->email);

        if ($emailOwner != null && $emailOwner->id != $user->id) {
            throw new ValidationException("Email sudah digunakan");
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->role = $request->role;

        if (!empty($request->password)) {
            $user->password = password_hash(
                $request->password,
                PASSWORD_BCRYPT
            );
        }

        if (!empty($request->avatar)) {
            $user->avatar = $request->avatar;
        }

        $this->userRepository->update($user);

        $response = new UserUpdateResponse();
        $response->user = $user;

        return $response;
    }

    private function validateUpdateRequest(UserUpdateRequest $request): void
    {
        if (
            $request->id == null ||
            $request->name == null ||
            trim($request->name) == "" ||

            $request->email == null ||
            trim($request->email) == "" ||

            $request->role == null ||
            trim($request->role) == ""
        ) {
            throw new ValidationException("Data tidak boleh kosong");
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Email tidak valid");
        }

        if (!in_array($request->role, ['admin', 'user'])) {
            throw new ValidationException("Role tidak valid");
        }

        if (
            !empty($request->password) &&
            strlen($request->password) < 6
        ) {
            throw new ValidationException("Password minimal 6 karakter");
        }
    }

    public function delete(int $id): void
    {

        $user = $this->userRepository->findById($id);


        if ($user == null) {

            throw new ValidationException(
                "User tidak ditemukan"
            );

        }


        // hapus file avatar
        if (
            $user->avatar &&
            $user->avatar !== "default.png"
        ) {

            $path = __DIR__
                . "/../../public/uploads/avatar/"
                . $user->avatar;


            if (file_exists($path)) {

                unlink($path);

            }

        }


        // soft delete database
        $this->userRepository->softDelete($id);

    }

    public function findById(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if ($user == null) {
            throw new ValidationException("User tidak ditemukan");
        }

        return $user;
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }
}
