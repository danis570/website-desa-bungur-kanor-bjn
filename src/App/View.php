<?php

namespace Kkn27Unirow\WebsiteDesaBungur\App;

class View
{

    public static function renderPublicHome($model)
    {
        require __DIR__ . '/../View/Public/index.php';
    }

    public static function renderPublic(string $view, $model)
    {
        require __DIR__ . '/../View/Public/Layouts/header.php';
        require __DIR__ . '/../View/Public/' . $view . '.php';
        require __DIR__ . '/../View/Public/Layouts/footer.php';
    }

    public static function renderUser(string $view, $model)
    {
        require __DIR__ . '/../View/User/Layouts/header.php';
        require __DIR__ . '/../View/User/' . $view . '.php';
        require __DIR__ . '/../View/User/Layouts/footer.php';
    }

    public static function renderAdmin(string $view, $model)
    {
        require __DIR__ . '/../View/Admin/Layouts/header.php';
        require __DIR__ . '/../View/Admin/' . $view . '.php';
        require __DIR__ . '/../View/Admin/Layouts/footer.php';
    }
    public static function redirect(string $url)
    {
        header("Location: $url");
        if (getenv("mode") != "dev") {
            exit();
        }
    }

}