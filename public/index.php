<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Kkn27Unirow\WebsiteDesaBungur\App\Router;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Auth\AuthController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\PublicController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\UserController as AdminUserController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\NewsController as UserNewsController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\PhotoController as UserPhotoController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\UserController as UsersController;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\AdminMiddleware;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\MustLoginMiddleware;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');

// Admin-User Controller

// Auth Controller
Router::add('GET', '/login', AuthController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/login', AuthController::class, 'postLogin', [MustNotLoginMiddleware::class]);

// Admin Controller
Router::add('GET', '/admin/dashboard', AdminUserController::class, 'adminDashboard', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Admin - User management
Router::add('GET', '/admin/users', AdminUserController::class, 'users', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/users/add', AdminUserController::class, 'userAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/users/add', AdminUserController::class, 'postUserAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/users/edit/([0-9]+)', AdminUserController::class, 'edit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/users/update', AdminUserController::class, 'update', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/users/delete', AdminUserController::class, 'delete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Admin - Logout
Router::add('GET', '/admin/logout', AdminUserController::class, 'logout', [MustLoginMiddleware::class, AdminMiddleware::class]);


// ==========================================================
// USER DASHBOARD
// ==========================================================
Router::add('GET', '/user/dashboard', UsersController::class, 'userDashboard', [MustLoginMiddleware::class]);

// ==========================================================
// USER NEWS
// ==========================================================
// User News Routes
Router::add('GET', '/user/news', UserNewsController::class, 'index', [MustLoginMiddleware::class]);
Router::add('GET', '/user/news/add', UserNewsController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/user/news/add', UserNewsController::class, 'postCreate', [MustLoginMiddleware::class]);
Router::add('GET', '/user/news/edit/([0-9]+)', UserNewsController::class, 'edit', [MustLoginMiddleware::class]);
Router::add('POST', '/user/news/edit/([0-9]+)', UserNewsController::class, 'postEdit', [MustLoginMiddleware::class]);
Router::add('POST', '/user/news/delete/([0-9]+)', UserNewsController::class, 'delete', [MustLoginMiddleware::class]);

// ==========================================================
// USER PHOTO
// ==========================================================
// User Photo Routes
Router::add('GET', '/user/photo', UserPhotoController::class, 'index', [MustLoginMiddleware::class]);
Router::add('GET', '/user/photo/add', UserPhotoController::class, 'create', [MustLoginMiddleware::class]);
Router::add('POST', '/user/photo/add', UserPhotoController::class, 'postCreate', [MustLoginMiddleware::class]);
Router::add('GET', '/user/photo/edit/([0-9]+)', UserPhotoController::class, 'edit', [MustLoginMiddleware::class]);
Router::add('POST', '/user/photo/edit/([0-9]+)', UserPhotoController::class, 'postEdit', [MustLoginMiddleware::class]);
Router::add('POST', '/user/photo/delete/([0-9]+)', UserPhotoController::class, 'delete', [MustLoginMiddleware::class]);
// ==========================================================
// USER LOGOUT
// ==========================================================
Router::add('GET', '/user/logout', UsersController::class, 'logout', [MustLoginMiddleware::class]);


// Public Controller
Router::add('GET', '/', PublicController::class, 'index', [MustNotLoginMiddleware::class]);
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