<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;

class PhotoController
{
    private PhotoRepository $photoRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->photoRepository = new PhotoRepository($pdo);
    }

    /**
     * Display photo gallery
     */
    public function photo(): void
    {
        $photos = $this->photoRepository->findAll();

        View::renderPublic('Photo/photo', [
            'title' => 'Galeri Foto',
            'current' => 'photo',
            'photos' => $photos
        ]);
    }
}