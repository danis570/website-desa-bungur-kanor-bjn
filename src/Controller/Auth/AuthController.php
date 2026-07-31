<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Auth;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UserLoginRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;
use Kkn27Unirow\WebsiteDesaBungur\Service\UserService;

class AuthController
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

    public function login()
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

            $session = $this->sessionService->create($response->user->id);

            setcookie(
                SessionService::$COOKIE_NAME,
                $session->id,
                [
                    'expires' => time() + (60 * 60 * 24 * 30),
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );

            // Redirect by role
            if ($response->user->role === 'admin') {
                View::redirect('/admin/dashboard');
                return;
            }

            View::redirect('/user/dashboard');

        } catch (ValidationException $e) {

            View::renderPublic('Auth/login', [
                'title' => 'Login',
                'current' => '',
                'error' => $e->getMessage()
            ]);

        }
    }

    public function logout()
    {
        $sessionId = $_COOKIE[SessionService::$COOKIE_NAME] ?? null;

        if ($sessionId !== null) {
            $this->sessionService->destroy($sessionId);
        }

        setcookie(
            SessionService::$COOKIE_NAME,
            '',
            [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );

        View::redirect('login');
    }
}