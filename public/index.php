<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Kkn27Unirow\WebsiteDesaBungur\App\Router;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\DemographicController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\DemographicController as PublicDemographicController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\LandingPageController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\LandingPageController as PublicLandingPageController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\UmkmController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\UmkmController as PublicUmkmController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Auth\AuthController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\PublicController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\UserController as AdminUserController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Admin\VillageProfileController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\NewsController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\PhotoController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\ProfileController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\Public\SearchController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\NewsController as UserNewsController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\PhotoController as UserPhotoController;
use Kkn27Unirow\WebsiteDesaBungur\Controller\User\UserController as UsersController;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\AdminMiddleware;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\MustLoginMiddleware;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\MustNotLoginMiddleware;
use Kkn27Unirow\WebsiteDesaBungur\Middleware\UserMiddleware;

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
// Admin UMKM Routes
Router::add('GET', '/admin/umkm', UmkmController::class, 'index', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/umkm/add', UmkmController::class, 'add', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/umkm/add', UmkmController::class, 'postAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/umkm/edit/([0-9]+)', UmkmController::class, 'edit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/umkm/edit/([0-9]+)', UmkmController::class, 'postEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/umkm/delete', UmkmController::class, 'delete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// ==========================================================
// ADMIN DEMOGRAPHIC
// ==========================================================
Router::add('GET', '/admin/demographic', DemographicController::class, 'index', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/demographic/gender/edit', DemographicController::class, 'editGender', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/demographic/gender/edit', DemographicController::class, 'postEditGender', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/demographic/education/edit', DemographicController::class, 'editEducation', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/demographic/education/edit', DemographicController::class, 'postEditEducation', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/demographic/religion/edit', DemographicController::class, 'editReligion', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/demographic/religion/edit', DemographicController::class, 'postEditReligion', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/demographic/age-group/edit', DemographicController::class, 'editAgeGroup', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/demographic/age-group/edit', DemographicController::class, 'postEditAgeGroup', [MustLoginMiddleware::class, AdminMiddleware::class]);
// ==========================================================
// ADMIN VILLAGE PROFILE
// ==========================================================
// Dashboard
Router::add('GET', '/admin/profile', VillageProfileController::class, 'index', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Officials
Router::add('GET', '/admin/profile/officials', VillageProfileController::class, 'officials', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/officials/add', VillageProfileController::class, 'officialAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/officials/add', VillageProfileController::class, 'postOfficialAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/officials/edit/([0-9]+)', VillageProfileController::class, 'officialEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/officials/edit/([0-9]+)', VillageProfileController::class, 'postOfficialEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/officials/delete', VillageProfileController::class, 'postOfficialDelete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Histories
Router::add('GET', '/admin/profile/histories', VillageProfileController::class, 'histories', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/histories/add', VillageProfileController::class, 'historyAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/histories/add', VillageProfileController::class, 'postHistoryAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/histories/edit/([0-9]+)', VillageProfileController::class, 'historyEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/histories/edit/([0-9]+)', VillageProfileController::class, 'postHistoryEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/histories/delete', VillageProfileController::class, 'postHistoryDelete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Visions & Missions
Router::add('GET', '/admin/profile/visions-missions', VillageProfileController::class, 'visionsMissions', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/visions-missions/add', VillageProfileController::class, 'visionMissionAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/visions-missions/add', VillageProfileController::class, 'postVisionMissionAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/profile/visions-missions/edit/([0-9]+)', VillageProfileController::class, 'visionMissionEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/visions-missions/edit/([0-9]+)', VillageProfileController::class, 'postVisionMissionEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/profile/visions-missions/delete', VillageProfileController::class, 'postVisionMissionDelete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// ==========================================================
// ADMIN LANDING PAGE
// ==========================================================
// Hero Banners
Router::add('GET', '/admin/landing/banners', LandingPageController::class, 'banners', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/landing/banners/add', LandingPageController::class, 'bannerAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/banners/add', LandingPageController::class, 'postBannerAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/landing/banners/edit/([0-9]+)', LandingPageController::class, 'bannerEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/banners/edit/([0-9]+)', LandingPageController::class, 'postBannerEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/banners/delete', LandingPageController::class, 'postBannerDelete', [MustLoginMiddleware::class, AdminMiddleware::class]);
// Village Greetings
Router::add('GET', '/admin/landing/greetings', LandingPageController::class, 'greetings', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/landing/greetings/add', LandingPageController::class, 'greetingAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/greetings/add', LandingPageController::class, 'postGreetingAdd', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('GET', '/admin/landing/greetings/edit/([0-9]+)', LandingPageController::class, 'greetingEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/greetings/edit/([0-9]+)', LandingPageController::class, 'postGreetingEdit', [MustLoginMiddleware::class, AdminMiddleware::class]);
Router::add('POST', '/admin/landing/greetings/delete', LandingPageController::class, 'postGreetingDelete', [MustLoginMiddleware::class, AdminMiddleware::class]);

// Admin - Logout
Router::add('GET', '/admin/logout', AdminUserController::class, 'logout', [MustLoginMiddleware::class, AdminMiddleware::class]);

// USER DASHBOARD
Router::add('GET', '/user/dashboard', UsersController::class, 'userDashboard', [MustLoginMiddleware::class, UserMiddleware::class]);
// USER NEWS
Router::add('GET', '/user/news', UserNewsController::class, 'index', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('GET', '/user/news/add', UserNewsController::class, 'create', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/news/add', UserNewsController::class, 'postCreate', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('GET', '/user/news/edit/([0-9]+)', UserNewsController::class, 'edit', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/news/edit/([0-9]+)', UserNewsController::class, 'postEdit', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/news/delete/([0-9]+)', UserNewsController::class, 'delete', [MustLoginMiddleware::class, UserMiddleware::class]);

// ==========================================================
// USER PHOTO
// ==========================================================
// User Photo Routes
Router::add('GET', '/user/photo', UserPhotoController::class, 'index', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('GET', '/user/photo/add', UserPhotoController::class, 'create', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/photo/add', UserPhotoController::class, 'postCreate', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('GET', '/user/photo/edit/([0-9]+)', UserPhotoController::class, 'edit', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/photo/edit/([0-9]+)', UserPhotoController::class, 'postEdit', [MustLoginMiddleware::class, UserMiddleware::class]);
Router::add('POST', '/user/photo/delete/([0-9]+)', UserPhotoController::class, 'delete', [MustLoginMiddleware::class, UserMiddleware::class]);
// ==========================================================
// USER LOGOUT
// ==========================================================
Router::add('GET', '/user/logout', UsersController::class, 'logout', [MustLoginMiddleware::class, UserMiddleware::class]);


// Public Controller
// Landing Page / Home
Router::add('GET', '/', PublicLandingPageController::class, 'index', []);
// Profile utama
Router::add('GET', '/profil', ProfileController::class, 'profile');
// Aparatur Desa
Router::add('GET', '/profil/aparatur', ProfileController::class, 'apparatusActive');
Router::add('GET', '/profil/aparatur/semua', ProfileController::class, 'apparatusHistory');
// Sejarah Desa
Router::add('GET', '/profil/sejarah', ProfileController::class, 'history');
// ==========================================================
// PUBLIC ROUTES - DEMOGRAPHICS
// ==========================================================
Router::add('GET', '/demografi', PublicDemographicController::class, 'index');

// ==========================================================
// PUBLIC ROUTES - NEWS
// ==========================================================

Router::add('GET', '/kabar', NewsController::class, 'index');
Router::add('GET', '/kabar/arsip', NewsController::class, 'archive');
Router::add('GET', '/kabar/detail/([a-zA-Z0-9\-]+)', NewsController::class, 'detail');
Router::add('GET', '/kabar/author/(.+)', NewsController::class, 'author');
// Photo
Router::add('GET', '/photo', PhotoController::class, 'photo', []);
// ==========================================================
// PUBLIC ROUTES - UMKM
// ==========================================================
Router::add('GET', '/umkm', PublicUmkmController::class, 'index');
Router::add('GET', '/umkm/detail/([a-zA-Z0-9\-]+)', PublicUmkmController::class, 'detail');
// ==========================================================
// PUBLIC ROUTES - SEARCH
// ==========================================================

Router::add('GET', '/search', SearchController::class, 'results');
Router::add('GET', '/search/api', SearchController::class, 'search');

Router::run();