<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\HeroBanner;
use Kkn27Unirow\WebsiteDesaBungur\Repository\HeroBannerRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class HeroBannerRepositoryTest extends TestCase
{
    private PDO $pdo;
    private HeroBannerRepository $bannerRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->bannerRepository = new HeroBannerRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->bannerRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createBanner(
        string $title = 'Selamat Datang di Desa Bungur',
        string $description = 'Desa Bungur adalah desa yang maju',
        string $image = 'banner_123.jpg'
    ): HeroBanner {
        $banner = new HeroBanner();
        $banner->title = $title;
        $banner->description = $description;
        $banner->image = $image;

        return $this->bannerRepository->save($banner);
    }

    public function testSaveSuccess(): void
    {
        $banner = new HeroBanner();
        $banner->title = 'Selamat Datang di Desa Bungur';
        $banner->description = 'Desa Bungur adalah desa yang maju dan mandiri';
        $banner->image = 'banner_123.jpg';

        $saved = $this->bannerRepository->save($banner);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('Selamat Datang di Desa Bungur', $saved->title);
        $this->assertEquals('Desa Bungur adalah desa yang maju dan mandiri', $saved->description);
        $this->assertEquals('banner_123.jpg', $saved->image);

        $found = $this->bannerRepository->findById($saved->id);
        $this->assertNotNull($found);
        $this->assertEquals('Selamat Datang di Desa Bungur', $found->title);
        $this->assertEquals('banner_123.jpg', $found->image);
    }

    public function testUpdateSuccess(): void
    {
        $banner = $this->createBanner('Selamat Datang', 'Desa Bungur Maju', 'banner_123.jpg');

        $banner->title = 'Selamat Datang Update';
        $banner->description = 'Desa Bungur Maju Update';
        $banner->image = 'banner_update.jpg';

        $updated = $this->bannerRepository->update($banner);

        $this->assertEquals('Selamat Datang Update', $updated->title);
        $this->assertEquals('Desa Bungur Maju Update', $updated->description);
        $this->assertEquals('banner_update.jpg', $updated->image);
        $this->assertNotNull($updated->updatedAt);

        $found = $this->bannerRepository->findById($banner->id);
        $this->assertNotNull($found);
        $this->assertEquals('Selamat Datang Update', $found->title);
        $this->assertEquals('banner_update.jpg', $found->image);
    }

    public function testFindByIdSuccess(): void
    {
        $banner = $this->createBanner('Selamat Datang', 'Desa Bungur Maju', 'banner_123.jpg');

        $found = $this->bannerRepository->findById($banner->id);

        $this->assertNotNull($found);
        $this->assertEquals($banner->id, $found->id);
        $this->assertEquals('Selamat Datang', $found->title);
        $this->assertEquals('Desa Bungur Maju', $found->description);
        $this->assertEquals('banner_123.jpg', $found->image);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->bannerRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testFindAllSuccess(): void
    {
        $this->createBanner('Banner 1', 'Deskripsi 1', 'banner1.jpg');
        $this->createBanner('Banner 2', 'Deskripsi 2', 'banner2.jpg');
        $this->createBanner('Banner 3', 'Deskripsi 3', 'banner3.jpg');

        $banners = $this->bannerRepository->findAll();

        $this->assertCount(3, $banners);
        $this->assertEquals('Banner 3', $banners[0]->title);
        $this->assertEquals('Banner 2', $banners[1]->title);
        $this->assertEquals('Banner 1', $banners[2]->title);

        foreach ($banners as $banner) {
            $this->assertNotNull($banner->id);
            $this->assertNotEmpty($banner->title);
            $this->assertNotEmpty($banner->image);
        }
    }

    public function testFindAllEmpty(): void
    {
        $banners = $this->bannerRepository->findAll();
        $this->assertEmpty($banners);
        $this->assertIsArray($banners);
    }

    public function testSoftDeleteSuccess(): void
    {
        $banner = $this->createBanner('Selamat Datang', 'Deskripsi', 'banner_123.jpg');

        $found = $this->bannerRepository->findById($banner->id);
        $this->assertNotNull($found);

        $this->bannerRepository->softDelete($banner->id);

        $found = $this->bannerRepository->findById($banner->id);
        $this->assertNull($found);

        $allBanners = $this->bannerRepository->findAll();
        $this->assertEmpty($allBanners);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM hero_banners WHERE id = ?");
        $statement->execute([$banner->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->bannerRepository->softDelete(99999);

        $allBanners = $this->bannerRepository->findAll();
        $this->assertEmpty($allBanners);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createBanner('Banner 1', 'Deskripsi 1', 'banner1.jpg');
        $this->createBanner('Banner 2', 'Deskripsi 2', 'banner2.jpg');

        $this->bannerRepository->deleteAll();

        $allBanners = $this->bannerRepository->findAll();
        $this->assertEmpty($allBanners);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM hero_banners");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $banner = new HeroBanner();
        $banner->title = '';
        $banner->description = '';
        $banner->image = '';

        $saved = $this->bannerRepository->save($banner);

        $this->assertNotNull($saved->id);
        $this->assertEquals('', $saved->title);
        $this->assertEquals('', $saved->description);
        $this->assertEquals('', $saved->image);
    }
}
