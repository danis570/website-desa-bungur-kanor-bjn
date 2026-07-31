<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Auth;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\UserService;

class AuthController
{
    private UserService $userService;
    private UserRepository $userRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $this->userRepository = new UserRepository($pdo);
        $this->userService = new UserService($this->userRepository);
    }
    function login()
    {
        View::renderPublic('Auth/login', [
            'title' => 'Login',
            'current' => ''
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->email = $_POST['email'] ?? null;
        $request->password = $_POST['password'] ?? null;

        try {
            $response = $this->userService->login($request);

            // Sementara, nanti bisa diganti SessionService
            $_SESSION['user_id'] = $response->user->id;

            header('Location: /admin/dashboard');
            exit();
        } catch (ValidationException $e) {

            View::renderPublic('Auth/login', [
                'title' => 'Login',
                'current' => '',
                'error' => $e->getMessage()
            ]);

        }
    }
}
