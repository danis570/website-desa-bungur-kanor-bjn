<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Session;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;

class SessionService
{
    public static string $COOKIE_NAME = "X-KKN27-SESSION";

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(
        SessionRepository $sessionRepository,
        UserRepository $userRepository
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(int $userId): Session
    {
        $session = new Session();
        $session->id = bin2hex(random_bytes(32));
        $session->userId = $userId;

        return $this->sessionRepository->save($session);
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? null;

        if ($sessionId === null) {
            return null;
        }

        $session = $this->sessionRepository->findById($sessionId);

        if ($session === null) {
            return null;
        }

        return $this->userRepository->findById($session->userId);
    }

    public function destroy(): void
{
    $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? null;

    if ($sessionId !== null) {

        $this->sessionRepository->deleteById($sessionId);

    }

   if (!headers_sent()) {
    setcookie(
        self::$COOKIE_NAME,
        '',
        time() - 3600,
        '/'
    );
}

    unset($_COOKIE[self::$COOKIE_NAME]);
}
}
