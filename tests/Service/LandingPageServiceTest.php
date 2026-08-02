<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\HeroBanner;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageGreeting;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\HeroBannerRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\LandingPageService;
use PDO;
use PHPUnit\Framework\TestCase;

class LandingPageServiceTest extends TestCase
{
    private PDO $pdo;
    private LandingPageService $service;
    private HeroBannerRepository $bannerRepository;
    private VillageGreetingRepository $greetingRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->bannerRepository = new HeroBannerRepository($this->pdo);
        $this->greetingRepository = new VillageGreetingRepository($this->pdo);

        $this->service = new LandingPageService(
            $this->bannerRepository,
            $this->greetingRepository
        );

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
        $this->greetingRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    // ==========================================================
    // BANNER TESTS
    // ==========================================================

    public function testCreateBannerSuccess(): void
    {
        $banner = new HeroBanner();
        $banner->title = 'Selamat Datang di Desa Bungur';
        $banner->description = 'Desa Bungur adalah desa yang maju';
        $banner->image = 'banner_123.jpg';

        $created = $this->service->createBanner($banner);

        $this->assertNotNull($created->id);
        $this->assertEquals('Selamat Datang di Desa Bungur', $created->title);
        $this->assertEquals('Desa Bungur adalah desa yang maju', $created->description);
        $this->assertEquals('banner_123.jpg', $created->image);
    }

    public function testCreateBannerWithEmptyTitle(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Judul banner tidak boleh kosong');

        $banner = new HeroBanner();
        $banner->title = '';
        $banner->description = 'Deskripsi';
        $banner->image = 'banner.jpg';

        $this->service->createBanner($banner);
    }

    public function testCreateBannerWithEmptyImage(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Gambar banner tidak boleh kosong');

        $banner = new HeroBanner();
        $banner->title = 'Judul';
        $banner->description = 'Deskripsi';
        $banner->image = '';

        $this->service->createBanner($banner);
    }

    public function testUpdateBannerSuccess(): void
    {
        $banner = new HeroBanner();
        $banner->title = 'Selamat Datang';
        $banner->description = 'Deskripsi Awal';
        $banner->image = 'banner_123.jpg';
        $created = $this->service->createBanner($banner);

        $created->title = 'Selamat Datang Update';
        $created->description = 'Deskripsi Update';
        $created->image = 'banner_update.jpg';

        $updated = $this->service->updateBanner($created);

        $this->assertEquals('Selamat Datang Update', $updated->title);
        $this->assertEquals('Deskripsi Update', $updated->description);
        $this->assertEquals('banner_update.jpg', $updated->image);
    }

    public function testUpdateBannerNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Banner tidak ditemukan');

        $banner = new HeroBanner();
        $banner->id = 99999;
        $banner->title = 'Judul';
        $banner->description = 'Deskripsi';
        $banner->image = 'banner.jpg';

        $this->service->updateBanner($banner);
    }

    public function testGetBannerByIdSuccess(): void
    {
        $banner = new HeroBanner();
        $banner->title = 'Selamat Datang';
        $banner->description = 'Deskripsi';
        $banner->image = 'banner_123.jpg';
        $created = $this->service->createBanner($banner);

        $found = $this->service->getBannerById($created->id);

        $this->assertNotNull($found);
        $this->assertEquals($created->id, $found->id);
        $this->assertEquals('Selamat Datang', $found->title);
    }

    public function testGetBannerByIdNotFound(): void
    {
        $found = $this->service->getBannerById(99999);
        $this->assertNull($found);
    }

    public function testGetAllBannersSuccess(): void
    {
        $banner1 = new HeroBanner();
        $banner1->title = 'Banner 1';
        $banner1->description = 'Deskripsi 1';
        $banner1->image = 'banner1.jpg';
        $this->service->createBanner($banner1);

        $banner2 = new HeroBanner();
        $banner2->title = 'Banner 2';
        $banner2->description = 'Deskripsi 2';
        $banner2->image = 'banner2.jpg';
        $this->service->createBanner($banner2);

        $banners = $this->service->getAllBanners();

        $this->assertCount(2, $banners);
        $this->assertEquals('Banner 2', $banners[0]->title);
        $this->assertEquals('Banner 1', $banners[1]->title);
    }

    public function testDeleteBannerSuccess(): void
    {
        $banner = new HeroBanner();
        $banner->title = 'Selamat Datang';
        $banner->description = 'Deskripsi';
        $banner->image = 'banner_123.jpg';
        $created = $this->service->createBanner($banner);

        $this->service->deleteBanner($created->id);

        $found = $this->service->getBannerById($created->id);
        $this->assertNull($found);
    }

    public function testDeleteBannerNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Banner tidak ditemukan');

        $this->service->deleteBanner(99999);
    }

    // ==========================================================
    // GREETING TESTS
    // ==========================================================

    public function testCreateGreetingSuccess(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = 'Ahmad Fauzi';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan Kepala Desa Bungur';
        $greeting->closing = 'Wassalamualaikum';
        $greeting->image = 'kades_123.jpg';
        $greeting->signatureImage = 'ttd_123.jpg';

        $created = $this->service->createGreeting($greeting);

        $this->assertNotNull($created->id);
        $this->assertEquals('Ahmad Fauzi', $created->name);
        $this->assertEquals('Assalamualaikum', $created->opening);
        $this->assertEquals('Sambutan Kepala Desa Bungur', $created->content);
        $this->assertEquals('Wassalamualaikum', $created->closing);
        $this->assertEquals('kades_123.jpg', $created->image);
        $this->assertEquals('ttd_123.jpg', $created->signatureImage);
    }

    public function testCreateGreetingWithEmptyName(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama tidak boleh kosong');

        $greeting = new VillageGreeting();
        $greeting->name = '';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan';
        $greeting->closing = 'Wassalamualaikum';

        $this->service->createGreeting($greeting);
    }

    public function testCreateGreetingWithEmptyContent(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Isi sambutan tidak boleh kosong');

        $greeting = new VillageGreeting();
        $greeting->name = 'Ahmad Fauzi';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = '';
        $greeting->closing = 'Wassalamualaikum';

        $this->service->createGreeting($greeting);
    }

    public function testUpdateGreetingSuccess(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = 'Ahmad Fauzi';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan Awal';
        $greeting->closing = 'Wassalamualaikum';
        $created = $this->service->createGreeting($greeting);

        $created->name = 'Ahmad Fauzi Update';
        $created->opening = 'Assalamualaikum Update';
        $created->content = 'Sambutan Update';
        $created->closing = 'Wassalamualaikum Update';
        $created->image = 'kades_update.jpg';
        $created->signatureImage = 'ttd_update.jpg';

        $updated = $this->service->updateGreeting($created);

        $this->assertEquals('Ahmad Fauzi Update', $updated->name);
        $this->assertEquals('Assalamualaikum Update', $updated->opening);
        $this->assertEquals('Sambutan Update', $updated->content);
        $this->assertEquals('Wassalamualaikum Update', $updated->closing);
        $this->assertEquals('kades_update.jpg', $updated->image);
        $this->assertEquals('ttd_update.jpg', $updated->signatureImage);
    }

    public function testUpdateGreetingNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Sambutan tidak ditemukan');

        $greeting = new VillageGreeting();
        $greeting->id = 99999;
        $greeting->name = 'Test';
        $greeting->opening = 'Test';
        $greeting->content = 'Test';
        $greeting->closing = 'Test';

        $this->service->updateGreeting($greeting);
    }

    public function testGetGreetingByIdSuccess(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = 'Ahmad Fauzi';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan';
        $greeting->closing = 'Wassalamualaikum';
        $created = $this->service->createGreeting($greeting);

        $found = $this->service->getGreetingById($created->id);

        $this->assertNotNull($found);
        $this->assertEquals($created->id, $found->id);
        $this->assertEquals('Ahmad Fauzi', $found->name);
        $this->assertEquals('Sambutan', $found->content);
    }

    public function testGetGreetingByIdNotFound(): void
    {
        $found = $this->service->getGreetingById(99999);
        $this->assertNull($found);
    }

    public function testGetFirstGreetingSuccess(): void
    {
        $this->createGreeting('First', 'Sambutan Pertama');
        $this->createGreeting('Second', 'Sambutan Kedua');

        $first = $this->service->getFirstGreeting();

        $this->assertNotNull($first);
        $this->assertEquals('First', $first->name);
    }

    public function testGetFirstGreetingEmpty(): void
    {
        $first = $this->service->getFirstGreeting();
        $this->assertNull($first);
    }

public function testGetAllGreetingsSuccess(): void
{
    // Tambahkan sleep agar created_at berbeda
    sleep(1);
    $greeting1 = new VillageGreeting();
    $greeting1->name = 'Greeting 1';
    $greeting1->opening = 'Assalamualaikum';
    $greeting1->content = 'Sambutan 1';
    $greeting1->closing = 'Wassalamualaikum';
    $this->service->createGreeting($greeting1);
    
    sleep(1);
    $greeting2 = new VillageGreeting();
    $greeting2->name = 'Greeting 2';
    $greeting2->opening = 'Assalamualaikum';
    $greeting2->content = 'Sambutan 2';
    $greeting2->closing = 'Wassalamualaikum';
    $this->service->createGreeting($greeting2);

    $greetings = $this->service->getAllGreetings();

    $this->assertCount(2, $greetings);
    $this->assertEquals('Greeting 2', $greetings[0]->name);
    $this->assertEquals('Greeting 1', $greetings[1]->name);
}

    public function testDeleteGreetingSuccess(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = 'Ahmad Fauzi';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan';
        $greeting->closing = 'Wassalamualaikum';
        $created = $this->service->createGreeting($greeting);

        $this->service->deleteGreeting($created->id);

        $found = $this->service->getGreetingById($created->id);
        $this->assertNull($found);
    }

    public function testDeleteGreetingNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Sambutan tidak ditemukan');

        $this->service->deleteGreeting(99999);
    }

    private function createGreeting(string $name, string $content): VillageGreeting
    {
        $greeting = new VillageGreeting();
        $greeting->name = $name;
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = $content;
        $greeting->closing = 'Wassalamualaikum';
        $greeting->image = 'kades_123.jpg';
        $greeting->signatureImage = 'ttd_123.jpg';

        return $this->service->createGreeting($greeting);
    }

    // ==========================================================
    // DASHBOARD SUMMARY TESTS
    // ==========================================================

    public function testGetDashboardSummarySuccess(): void
    {
        // Create banners
        $banner1 = new HeroBanner();
        $banner1->title = 'Banner 1';
        $banner1->description = 'Deskripsi 1';
        $banner1->image = 'banner1.jpg';
        $this->service->createBanner($banner1);

        $banner2 = new HeroBanner();
        $banner2->title = 'Banner 2';
        $banner2->description = 'Deskripsi 2';
        $banner2->image = 'banner2.jpg';
        $this->service->createBanner($banner2);

        // Create greetings
        $greeting1 = new VillageGreeting();
        $greeting1->name = 'Greeting 1';
        $greeting1->opening = 'Assalamualaikum';
        $greeting1->content = 'Sambutan 1';
        $greeting1->closing = 'Wassalamualaikum';
        $this->service->createGreeting($greeting1);

        $summary = $this->service->getDashboardSummary();

        $this->assertArrayHasKey('total_banners', $summary);
        $this->assertArrayHasKey('total_greetings', $summary);
        $this->assertEquals(2, $summary['total_banners']);
        $this->assertEquals(1, $summary['total_greetings']);
    }

    public function testGetDashboardSummaryEmpty(): void
    {
        $summary = $this->service->getDashboardSummary();

        $this->assertEquals(0, $summary['total_banners']);
        $this->assertEquals(0, $summary['total_greetings']);
    }
}