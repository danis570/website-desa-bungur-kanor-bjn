<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\User;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
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
    function userDashboard()
    {
        View::renderUser('index', [
            'title' => 'Dashboard Useers',
            'current' => 'dashboard',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                [
                    'title' => 'User Dashboard',
                    'url' => null
                ]
            ]
        ]);
    }

    public function logout(): void
    {
        $this->sessionService->destroy();

        View::redirect('/login');
    }
}
