<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Admin;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;
use Kkn27Unirow\WebsiteDesaBungur\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->userService = new UserService($userRepository);

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }


    function adminDashboard()
    {
        View::renderAdmin('index', [
            'title' => 'Dashboard Admin',
            'current' => 'dashboard',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                [
                    'title' => 'Admin Dashboard',
                    'url' => null
                ]
            ]
        ]);
    }

    function users()
    {
        $users = $this->userService->findAll();

        $currentUser = $this->sessionService->current();

        View::renderAdmin('User/users', [
            'title' => 'User Management',
            'current' => 'users',

            // user yang sedang login
            'user' => $currentUser,

            // semua data user
            'users' => $users,

            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/admin/dashboard'
                ],
                [
                    'title' => 'User Management',
                    'url' => null
                ]
            ]
        ]);
    }

    function userAdd()
    {
        View::renderAdmin('User/user-add', [
            'title' => 'User Add',
            'current' => 'users',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                [
                    'title' => 'User management',
                    'url' => '/admin/users'
                ],
                [
                    'title' => 'Add User',
                    'url' => null
                ]
            ]
        ]);
    }

    public function postUserAdd()
    {
        $request = new UserCreateRequest();

        $request->name = $_POST['name'] ?? null;
        $request->email = $_POST['email'] ?? null;
        $request->password = $_POST['password'] ?? null;
        $request->position = $_POST['position'] ?? null;
        $request->role = $_POST['role'] ?? null;


        // sementara avatar
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

            $file = $_FILES['avatar'];

            // nama asli file
            $originalName = pathinfo(
                $file['name'],
                PATHINFO_FILENAME
            );

            // ekstensi file
            $extension = pathinfo(
                $file['name'],
                PATHINFO_EXTENSION
            );


            // ambil email untuk nama file
            $emailName = explode('@', $request->email)[0];

            // bersihkan karakter aneh
            $emailName = preg_replace(
                '/[^a-zA-Z0-9]/',
                '_',
                $emailName
            );


            // buat nama unik
            $filename =
                $emailName
                . "_"
                . time()
                . "_"
                . $originalName
                . "."
                . $extension;


            $uploadPath = __DIR__ . "/../../../public/uploads/avatar/";


            move_uploaded_file(
                $file['tmp_name'],
                $uploadPath . $filename
            );


            $request->avatar = $filename;


        } else {

            $request->avatar = "default.png";

        }


        try {

            $this->userService->create($request);
            $_SESSION['success_add'] = "Pengguna berhasil ditambahkan";
            View::redirect('/admin/users');


        } catch (ValidationException $e) {


            View::renderAdmin('User/user-add', [

                'title' => 'User Add',

                'current' => 'users',

                'error' => $e->getMessage(),

                'user' => $this->sessionService->current(),
                'breadcrumbs' => [
                    [
                        'title' => 'User management',
                        'url' => '/admin/users'
                    ],
                    [
                        'title' => 'Add User',
                        'url' => null
                    ]
                ]

            ]);

        }
    }

    public function edit(int $id)
    {
        try {

            $editUser = $this->userService->findById($id);

            View::renderAdmin('User/user-edit', [
                'title' => 'Edit User',
                'current' => 'users',
                'user' => $this->sessionService->current(),
                'editUser' => $editUser,
                'breadcrumbs' => [
                    [
                        'title' => 'User Management',
                        'url' => '/admin/users'
                    ],
                    [
                        'title' => 'Edit User',
                        'url' => null
                    ]
                ]
            ]);

        } catch (ValidationException $e) {

            $_SESSION['error'] = $e->getMessage();

            View::redirect('/admin/users');
        }
    }

    public function update()
    {
        $request = new UserUpdateRequest();

        $request->id = (int) ($_POST['id'] ?? 0);
        $request->name = $_POST['name'] ?? null;
        $request->email = $_POST['email'] ?? null;
        $request->password = $_POST['password'] ?? null;
        $request->position = $_POST['position'] ?? null;
        $request->role = $_POST['role'] ?? null;

        try {

            // ambil data lama
            $user = $this->userService->findById($request->id);

            // default avatar lama
            $request->avatar = $user->avatar;

            // upload avatar baru
            if (
                isset($_FILES['avatar']) &&
                $_FILES['avatar']['error'] === UPLOAD_ERR_OK
            ) {

                $uploadPath = __DIR__ . "/../../../public/uploads/avatar/";

                // hapus avatar lama
                if (
                    $user->avatar &&
                    file_exists($uploadPath . $user->avatar)
                ) {
                    unlink($uploadPath . $user->avatar);
                }

                // nama file unik
                $originalName = pathinfo(
                    $_FILES['avatar']['name'],
                    PATHINFO_FILENAME
                );

                $extension = strtolower(
                    pathinfo(
                        $_FILES['avatar']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $safeEmail = preg_replace(
                    '/[^a-zA-Z0-9]/',
                    '_',
                    $request->email
                );

                $fileName = time() .
                    "_" .
                    $safeEmail .
                    "_" .
                    $originalName .
                    "." .
                    $extension;

                move_uploaded_file(
                    $_FILES['avatar']['tmp_name'],
                    $uploadPath . $fileName
                );

                $request->avatar = $fileName;
            }

            $this->userService->update($request);

            $_SESSION['success'] = "User berhasil diperbarui";

            View::redirect("/admin/users");

        } catch (ValidationException $e) {

            View::renderAdmin('User/user-edit', [
                'title' => 'Edit User',
                'current' => 'users',
                'user' => $this->sessionService->current(),
                'editUser' => $request,
                'error' => $e->getMessage(),
                'breadcrumbs' => [
                    [
                        'title' => 'User Management',
                        'url' => '/admin/users'
                    ],
                    [
                        'title' => 'Edit User',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    public function delete()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $_SESSION['error'] = "ID user tidak valid.";
            View::redirect('/admin/users');
            return;
        }

        try {

            $this->userService->delete($id);

            $_SESSION['success'] = "User berhasil dihapus.";

        } catch (ValidationException $e) {

            $_SESSION['error'] = $e->getMessage();

        }

        View::redirect('/admin/users');
    }

    public function logout(): void
    {
        $this->sessionService->destroy();

        $_SESSION['success'] = "Berhasil logout";

        View::redirect('/login');
    }

}
