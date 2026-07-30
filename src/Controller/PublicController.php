<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller;

use Kkn27Unirow\WebsiteDesaBungur\App\View;

class PublicController
{
    function index()
    {
        View::renderPublicHome();
    }

    // Auth
    function login()
    {
        View::renderPublic('Auth/login', [
            'title' => 'Login',
            'current' => ''
        ]);
    }

    // Profile
    function profile()
    {
        View::renderPublic('Profile/profile', [
            'title' => 'Profile',
            'current' => 'profile'
        ]);
    }

     // Village Apparatus
    function villageApparatusActive()
    {
        View::renderPublic('Profile/village-apparatus', [
            'title' => 'Aparatur Desa Aktif',
            'current' => 'profile'
        ]);
    }

    function villageApparatusHistory()
    {
        View::renderPublic('Profile/village-apparatus-history', [
            'title' => 'Aparatur Desa Lengkap',
            'current' => 'profile'
        ]);
    }

    function villageHistory()
    {
        View::renderPublic('Profile/village-history', [
            'title' => 'Sejarah Desa Lengkap',
            'current' => 'profile'
        ]);
    }

    // News
    function VillageNews()
    {
        View::renderPublic('News/village-news', [
            'title' => 'kabar Desa',
            'current' => 'village-news'
        ]);
    }

     function VillageNewsDetail()
    {
        View::renderPublic('News/village-news-detail', [
            'title' => 'Detail kabar Desa',
            'current' => 'village-news'
        ]);
    }

     // Demographics
    function demographics()
    {
        View::renderPublic('Demographics/demographics', [
            'title' => 'Demografi',
            'current' => 'demographics'
        ]);
    }
    
     // Photo
    function photo()
    {
        View::renderPublic('Photo/photo', [
            'title' => 'Foto',
            'current' => 'photo'
        ]);
    }
      // UMKKs
    function msme()
    {
        View::renderPublic('MSMEs/msme', [
            'title' => 'UMKM',
            'current' => 'msme'
        ]);
    }
    function msmeDetail()
    {
        View::renderPublic('MSMEs/msme-detail', [
            'title' => 'Detail UMKM',
            'current' => 'msme'
        ]);
    }
}
