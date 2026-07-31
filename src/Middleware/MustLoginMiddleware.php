<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Middleware;

use Kkn27Unirow\WebsiteDesaBungur\App\Auth;
use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    public function before(): void
    {
        $user = $this->sessionService->current();

        if ($user === null) {
            View::redirect('/login');
            return;
        }

        if ($user->role !== 'admin') {
            View::redirect('/');
            return;
        }
    }
}