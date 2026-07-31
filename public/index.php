<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Kkn27Unirow\WebsiteDesaBungur\App\Router;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Auth\AuthController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\PublicController;

Database::getConnection('prod');

// Admin-User Controller

// Auth Controller
Router::add('GET', '/login', AuthController::class, 'login', []);
Router::add('POST', '/login', AuthController::class, 'postLogin', []);

// Public Controller
Router::add('GET', '/', PublicController::class, 'index', []);
// Profile
Router::add('GET', '/profil', PublicController::class, 'profile', []);
// Village Apparatus
Router::add('GET', '/aparatur-desa-aktif', PublicController::class, 'VillageApparatusActive', []);
Router::add('GET', '/aparatur-desa-lengkap', PublicController::class, 'VillageApparatusHistory', []);
// History
Router::add('GET', '/sejarah-desa-lengkap', PublicController::class, 'VillageHistory', []);
// News
Router::add('GET', '/kabar-desa', PublicController::class, 'VillageNews', []);
Router::add('GET', '/kabar-desa-detail', PublicController::class, 'VillageNewsDetail', []);
// Demographics
Router::add('GET', '/demografi', PublicController::class, 'demographics', []);
// Photo
Router::add('GET', '/photo', PublicController::class, 'photo', []);
// UMKMs
Router::add('GET', '/umkm', PublicController::class, 'msme', []);
Router::add('GET', '/umkm-detail', PublicController::class, 'msmeDetail', []);




Router::run();