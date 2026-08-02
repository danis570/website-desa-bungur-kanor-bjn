<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Umkm;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmCategory;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmMenuRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\UmkmService;
use PDO;
use PHPUnit\Framework\TestCase;

class UmkmServiceTest extends TestCase
{
    private PDO $pdo;
    private UmkmService $umkmService;
    private UmkmRepository $umkmRepository;
    private UmkmCategoryRepository $categoryRepository;
    private UmkmMenuRepository $menuRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->umkmRepository = new UmkmRepository($this->pdo);
        $this->categoryRepository = new UmkmCategoryRepository($this->pdo);
        $this->menuRepository = new UmkmMenuRepository($this->pdo);
        
        $this->umkmService = new UmkmService(
            $this->umkmRepository,
            $this->categoryRepository,
            $this->menuRepository
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
        $this->umkmRepository->deleteAll();
        $this->menuRepository->deleteAll();
        $this->pdo->exec("DELETE FROM umkm_categories");
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createCategory(string $name = 'Makanan', ?string $slug = null): UmkmCategory
    {
        $category = new UmkmCategory();
        $category->name = $name;
        $category->slug = $slug ?? strtolower($name) . '-' . uniqid();

        $statement = $this->pdo->prepare("
            INSERT INTO umkm_categories (name, slug)
            VALUES (?, ?)
        ");

        try {
            $statement->execute([$category->name, $category->slug]);
            $category->id = (int) $this->pdo->lastInsertId();
            return $category;
        } finally {
            $statement->closeCursor();
        }
    }

    private function createUmkm(
        string $name = 'Warung Makan',
        string $owner = 'Budi Santoso',
        ?UmkmCategory $category = null
    ): Umkm {
        if ($category === null) {
            $category = $this->createCategory();
        }

        $umkm = new Umkm();
        $umkm->categoryId = $category->id;
        $umkm->name = $name;
        $umkm->slug = strtolower(str_replace(' ', '-', $name));
        $umkm->owner = $owner;
        $umkm->description = 'Deskripsi UMKM';
        $umkm->address = 'Jl. Raya Desa Bungur No. 1';
        $umkm->businessHours = '08:00 - 20:00';
        $umkm->whatsapp = '081234567890';
        $umkm->featuredImage = 'umkm_123.jpg';
        $umkm->featuredImageAlt = 'Featured alt text';
        $umkm->ownerPhoto = 'owner_123.jpg';
        $umkm->ownerPhotoAlt = 'Owner alt text';

        return $this->umkmRepository->save($umkm);
    }

    public function testCreateSuccess(): void
    {
        $category = $this->createCategory();

        $request = new UmkmCreateRequest();
        $request->categoryId = $category->id;
        $request->name = 'Warung Makan Baru';
        $request->owner = 'Budi Santoso';
        $request->description = 'Deskripsi warung makan';
        $request->address = 'Jl. Raya No. 1';
        $request->businessHours = '08:00 - 20:00';
        $request->whatsapp = '081234567890';
        $request->mapsEmbedUrl = 'https://maps.google.com/embed';
        $request->featuredImage = 'umkm_123.jpg';
        $request->featuredImageAlt = 'Featured alt text';
        $request->ownerPhoto = 'owner_123.jpg';
        $request->ownerPhotoAlt = 'Owner alt text';
        
        // Tambahkan menu
        $request->menus = [
            [
                'name' => 'Nasi Goreng',
                'price' => 15000,
                'image' => null
            ],
            [
                'name' => 'Mie Goreng',
                'price' => 12000,
                'image' => null
            ]
        ];

        $umkm = $this->umkmService->create($request);

        $this->assertNotNull($umkm->id);
        $this->assertIsInt($umkm->id);
        $this->assertEquals('Warung Makan Baru', $umkm->name);
        $this->assertEquals('warung-makan-baru', $umkm->slug);
        $this->assertEquals('Budi Santoso', $umkm->owner);
        $this->assertEquals($category->id, $umkm->categoryId);
        $this->assertEquals('umkm_123.jpg', $umkm->featuredImage);
        $this->assertEquals('Featured alt text', $umkm->featuredImageAlt);
        $this->assertEquals('owner_123.jpg', $umkm->ownerPhoto);
        $this->assertEquals('Owner alt text', $umkm->ownerPhotoAlt);
        
        // Cek menu
        $this->assertCount(2, $umkm->menus);
        $this->assertEquals('Nasi Goreng', $umkm->menus[0]->name);
        $this->assertEquals(15000, $umkm->menus[0]->price);

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNotNull($foundUmkm);
        $this->assertEquals('Warung Makan Baru', $foundUmkm->name);
        $this->assertEquals('warung-makan-baru', $foundUmkm->slug);
    }

    public function testCreateWithEmptyName(): void
    {
        $category = $this->createCategory();

        $request = new UmkmCreateRequest();
        $request->categoryId = $category->id;
        $request->name = '';
        $request->owner = 'Budi Santoso';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama UMKM tidak boleh kosong');

        $this->umkmService->create($request);
    }

    public function testCreateWithEmptyOwner(): void
    {
        $category = $this->createCategory();

        $request = new UmkmCreateRequest();
        $request->categoryId = $category->id;
        $request->name = 'Warung Makan';
        $request->owner = '';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama pemilik tidak boleh kosong');

        $this->umkmService->create($request);
    }

    public function testCreateWithInvalidCategory(): void
    {
        $request = new UmkmCreateRequest();
        $request->categoryId = 99999;
        $request->name = 'Warung Makan';
        $request->owner = 'Budi Santoso';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori tidak ditemukan');

        $this->umkmService->create($request);
    }

    public function testCreateWithZeroCategoryId(): void
    {
        $request = new UmkmCreateRequest();
        $request->categoryId = 0;
        $request->name = 'Warung Makan';
        $request->owner = 'Budi Santoso';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori tidak valid');

        $this->umkmService->create($request);
    }

    public function testUpdateSuccess(): void
    {
        $category = $this->createCategory();
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso', $category);

        $request = new UmkmUpdateRequest();
        $request->id = $umkm->id;
        $request->categoryId = $category->id;
        $request->name = 'Warung Makan Update';
        $request->owner = 'Budi Santoso Update';
        $request->description = 'Deskripsi update';
        $request->address = 'Jl. Raya No. 2';
        $request->businessHours = '09:00 - 21:00';
        $request->whatsapp = '081298765432';
        $request->mapsEmbedUrl = 'https://maps.google.com/embed/update';
        $request->featuredImage = 'umkm_update.jpg';
        $request->featuredImageAlt = 'Updated featured alt';
        $request->ownerPhoto = 'owner_update.jpg';
        $request->ownerPhotoAlt = 'Updated owner alt';
        
        // Tambahkan menu
        $request->menus = [
            [
                'name' => 'Menu Update 1',
                'price' => 20000,
                'image' => null
            ]
        ];

        $updatedUmkm = $this->umkmService->update($request);

        $this->assertEquals($umkm->id, $updatedUmkm->id);
        $this->assertEquals('Warung Makan Update', $updatedUmkm->name);
        $this->assertEquals('warung-makan-update', $updatedUmkm->slug);
        $this->assertEquals('Budi Santoso Update', $updatedUmkm->owner);
        $this->assertEquals('umkm_update.jpg', $updatedUmkm->featuredImage);
        $this->assertEquals('Updated featured alt', $updatedUmkm->featuredImageAlt);
        $this->assertEquals('owner_update.jpg', $updatedUmkm->ownerPhoto);
        $this->assertEquals('Updated owner alt', $updatedUmkm->ownerPhotoAlt);
        
        // Cek menu
        $this->assertCount(1, $updatedUmkm->menus);
        $this->assertEquals('Menu Update 1', $updatedUmkm->menus[0]->name);

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNotNull($foundUmkm);
        $this->assertEquals('Warung Makan Update', $foundUmkm->name);
        $this->assertEquals('warung-makan-update', $foundUmkm->slug);
    }

    public function testUpdateWithInvalidId(): void
    {
        $request = new UmkmUpdateRequest();
        $request->id = 99999;
        $request->categoryId = 1;
        $request->name = 'Warung Makan';
        $request->owner = 'Budi Santoso';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('UMKM tidak ditemukan');

        $this->umkmService->update($request);
    }

    public function testUpdateWithEmptyName(): void
    {
        $category = $this->createCategory();
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso', $category);

        $request = new UmkmUpdateRequest();
        $request->id = $umkm->id;
        $request->categoryId = $category->id;
        $request->name = '';
        $request->owner = 'Budi Santoso';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama UMKM tidak boleh kosong');

        $this->umkmService->update($request);
    }

    public function testUpdateWithEmptyOwner(): void
    {
        $category = $this->createCategory();
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso', $category);

        $request = new UmkmUpdateRequest();
        $request->id = $umkm->id;
        $request->categoryId = $category->id;
        $request->name = 'Warung Makan';
        $request->owner = '';

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama pemilik tidak boleh kosong');

        $this->umkmService->update($request);
    }

    public function testFindByIdSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso');

        $foundUmkm = $this->umkmService->findById($umkm->id);

        $this->assertNotNull($foundUmkm);
        $this->assertEquals($umkm->id, $foundUmkm->id);
        $this->assertEquals('Warung Makan', $foundUmkm->name);
        $this->assertEquals('Budi Santoso', $foundUmkm->owner);
        $this->assertNotEmpty($foundUmkm->categoryName);
        $this->assertNotEmpty($foundUmkm->slug);
    }

    public function testFindByIdNotFound(): void
    {
        $foundUmkm = $this->umkmService->findById(99999);
        $this->assertNull($foundUmkm);
    }

    public function testFindAllSuccess(): void
    {
        $this->createUmkm('Warung A', 'Owner A');
        $this->createUmkm('Warung B', 'Owner B');
        $this->createUmkm('Warung C', 'Owner C');

        $umkms = $this->umkmService->findAll();

        $this->assertCount(3, $umkms);
        $this->assertEquals('Warung C', $umkms[0]->name);
        $this->assertEquals('Warung B', $umkms[1]->name);
        $this->assertEquals('Warung A', $umkms[2]->name);

        foreach ($umkms as $umkm) {
            $this->assertNotEmpty($umkm->categoryName);
            $this->assertNotEmpty($umkm->slug);
        }
    }

    public function testFindAllEmpty(): void
    {
        $umkms = $this->umkmService->findAll();
        $this->assertEmpty($umkms);
        $this->assertIsArray($umkms);
    }

    public function testFindByCategoryIdSuccess(): void
    {
        $category1 = $this->createCategory('Makanan', 'makanan');
        $category2 = $this->createCategory('Minuman', 'minuman');

        $this->createUmkm('Warung Makan 1', 'Owner 1', $category1);
        $this->createUmkm('Warung Makan 2', 'Owner 2', $category1);
        $this->createUmkm('Kedai Minuman', 'Owner 3', $category2);

        $category1Umkms = $this->umkmService->findByCategoryId($category1->id);

        $this->assertCount(2, $category1Umkms);
        $this->assertEquals($category1->id, $category1Umkms[0]->categoryId);
        $this->assertEquals($category1->id, $category1Umkms[1]->categoryId);

        $category2Umkms = $this->umkmService->findByCategoryId($category2->id);
        $this->assertCount(1, $category2Umkms);
        $this->assertEquals($category2->id, $category2Umkms[0]->categoryId);
    }

    public function testFindByCategoryIdEmpty(): void
    {
        $category = $this->createCategory('Makanan', 'makanan');

        $umkms = $this->umkmService->findByCategoryId($category->id);
        $this->assertEmpty($umkms);
        $this->assertIsArray($umkms);
    }

    public function testFindByCategoryIdWithInvalidCategory(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori tidak ditemukan');

        $this->umkmService->findByCategoryId(99999);
    }

    public function testDeleteSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso');

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNotNull($foundUmkm);

        $this->umkmService->delete($umkm->id);

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNull($foundUmkm);

        $allUmkms = $this->umkmRepository->findAll();
        $this->assertEmpty($allUmkms);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM umkms WHERE id = ?");
        $statement->execute([$umkm->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testDeleteNonExistentUmkm(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('UMKM tidak ditemukan');

        $this->umkmService->delete(99999);
    }
}