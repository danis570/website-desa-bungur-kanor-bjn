<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Umkm;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmCategory;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class UmkmRepositoryTest extends TestCase
{
    private PDO $pdo;
    private UmkmRepository $umkmRepository;
    private UmkmCategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->umkmRepository = new UmkmRepository($this->pdo);
        $this->categoryRepository = new UmkmCategoryRepository($this->pdo);
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
        ?UmkmCategory $category = null,
        string $slug = null
    ): Umkm {
        if ($category === null) {
            $category = $this->createCategory();
        }

        $umkm = new Umkm();
        $umkm->categoryId = $category->id;
        $umkm->name = $name;
        $umkm->slug = $slug ?? strtolower(str_replace(' ', '-', $name));
        $umkm->owner = $owner;
        $umkm->description = 'Deskripsi UMKM';
        $umkm->address = 'Jl. Raya Desa Bungur No. 1';
        $umkm->businessHours = '08:00 - 20:00';
        $umkm->whatsapp = '081234567890';
        $umkm->mapsEmbedUrl = 'https://maps.google.com/embed';

        return $this->umkmRepository->save($umkm);
    }

    public function testSaveSuccess(): void
    {
        $category = $this->createCategory();

        $umkm = new Umkm();
        $umkm->categoryId = $category->id;
        $umkm->name = 'Warung Makan Baru';
        $umkm->slug = 'warung-makan-baru';
        $umkm->owner = 'Budi Santoso';
        $umkm->description = 'Deskripsi warung makan';
        $umkm->address = 'Jl. Raya No. 1';
        $umkm->businessHours = '08:00 - 20:00';
        $umkm->whatsapp = '081234567890';
        $umkm->mapsEmbedUrl = 'https://maps.google.com/embed';
        $umkm->featuredImage = 'umkm_123.jpg';
        $umkm->featuredImageAlt = 'Featured image alt text';
        $umkm->ownerPhoto = 'owner_123.jpg';
        $umkm->ownerPhotoAlt = 'Owner photo alt text';

        $savedUmkm = $this->umkmRepository->save($umkm);

        $this->assertNotNull($savedUmkm->id);
        $this->assertIsInt($savedUmkm->id);
        $this->assertEquals('Warung Makan Baru', $savedUmkm->name);
        $this->assertEquals('warung-makan-baru', $savedUmkm->slug);
        $this->assertEquals('Budi Santoso', $savedUmkm->owner);
        $this->assertEquals($category->id, $savedUmkm->categoryId);
        $this->assertEquals('umkm_123.jpg', $savedUmkm->featuredImage);
        $this->assertEquals('Featured image alt text', $savedUmkm->featuredImageAlt);
        $this->assertEquals('owner_123.jpg', $savedUmkm->ownerPhoto);
        $this->assertEquals('Owner photo alt text', $savedUmkm->ownerPhotoAlt);

        $foundUmkm = $this->umkmRepository->findById($savedUmkm->id);
        $this->assertNotNull($foundUmkm);
        $this->assertEquals('Warung Makan Baru', $foundUmkm->name);
        $this->assertEquals('warung-makan-baru', $foundUmkm->slug);
        $this->assertEquals('Budi Santoso', $foundUmkm->owner);
    }

    public function testUpdateSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso');

        $umkm->name = 'Warung Makan Update';
        $umkm->slug = 'warung-makan-update';
        $umkm->owner = 'Budi Santoso Update';
        $umkm->description = 'Deskripsi update';
        $umkm->address = 'Jl. Raya No. 2';
        $umkm->businessHours = '09:00 - 21:00';
        $umkm->whatsapp = '081298765432';
        $umkm->featuredImage = 'umkm_update.jpg';
        $umkm->featuredImageAlt = 'Updated featured alt text';
        $umkm->ownerPhoto = 'owner_update.jpg';
        $umkm->ownerPhotoAlt = 'Updated owner alt text';

        $updatedUmkm = $this->umkmRepository->update($umkm);

        $this->assertEquals('Warung Makan Update', $updatedUmkm->name);
        $this->assertEquals('warung-makan-update', $updatedUmkm->slug);
        $this->assertEquals('Budi Santoso Update', $updatedUmkm->owner);
        $this->assertEquals('umkm_update.jpg', $updatedUmkm->featuredImage);
        $this->assertEquals('Updated featured alt text', $updatedUmkm->featuredImageAlt);
        $this->assertEquals('owner_update.jpg', $updatedUmkm->ownerPhoto);
        $this->assertEquals('Updated owner alt text', $updatedUmkm->ownerPhotoAlt);
        $this->assertNotNull($updatedUmkm->updatedAt);

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNotNull($foundUmkm);
        $this->assertEquals('Warung Makan Update', $foundUmkm->name);
        $this->assertEquals('warung-makan-update', $foundUmkm->slug);
        $this->assertEquals('Budi Santoso Update', $foundUmkm->owner);
    }

    public function testFindByIdSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso');

        $foundUmkm = $this->umkmRepository->findById($umkm->id);

        $this->assertNotNull($foundUmkm);
        $this->assertEquals($umkm->id, $foundUmkm->id);
        $this->assertEquals('Warung Makan', $foundUmkm->name);
        $this->assertEquals('Budi Santoso', $foundUmkm->owner);
        $this->assertNotEmpty($foundUmkm->categoryName);
        $this->assertNotEmpty($foundUmkm->slug);
    }

    public function testFindByIdNotFound(): void
    {
        $foundUmkm = $this->umkmRepository->findById(99999);
        $this->assertNull($foundUmkm);
    }

    public function testFindBySlugSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso', null, 'warung-makan');

        $foundUmkm = $this->umkmRepository->findBySlug('warung-makan');

        $this->assertNotNull($foundUmkm);
        $this->assertEquals($umkm->id, $foundUmkm->id);
        $this->assertEquals('Warung Makan', $foundUmkm->name);
        $this->assertEquals('warung-makan', $foundUmkm->slug);
        $this->assertEquals('Budi Santoso', $foundUmkm->owner);
    }

    public function testFindBySlugNotFound(): void
    {
        $foundUmkm = $this->umkmRepository->findBySlug('non-existent-slug');
        $this->assertNull($foundUmkm);
    }

    public function testFindAllSuccess(): void
    {
        $this->createUmkm('Warung A', 'Owner A');
        $this->createUmkm('Warung B', 'Owner B');
        $this->createUmkm('Warung C', 'Owner C');

        $umkms = $this->umkmRepository->findAll();

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
        $umkms = $this->umkmRepository->findAll();
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

        $category1Umkms = $this->umkmRepository->findByCategoryId($category1->id);

        $this->assertCount(2, $category1Umkms);
        $this->assertEquals($category1->id, $category1Umkms[0]->categoryId);
        $this->assertEquals($category1->id, $category1Umkms[1]->categoryId);

        $category2Umkms = $this->umkmRepository->findByCategoryId($category2->id);
        $this->assertCount(1, $category2Umkms);
        $this->assertEquals($category2->id, $category2Umkms[0]->categoryId);
    }

    public function testFindByCategoryIdEmpty(): void
    {
        $category = $this->createCategory('Makanan', 'makanan');

        $umkms = $this->umkmRepository->findByCategoryId($category->id);
        $this->assertEmpty($umkms);
        $this->assertIsArray($umkms);
    }

    public function testSoftDeleteSuccess(): void
    {
        $umkm = $this->createUmkm('Warung Makan', 'Budi Santoso');

        $foundUmkm = $this->umkmRepository->findById($umkm->id);
        $this->assertNotNull($foundUmkm);

        $this->umkmRepository->softDelete($umkm->id);

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

    public function testSoftDeleteNonExistentId(): void
    {
        $this->umkmRepository->softDelete(99999);

        $allUmkms = $this->umkmRepository->findAll();
        $this->assertEmpty($allUmkms);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createUmkm('Warung A', 'Owner A');
        $this->createUmkm('Warung B', 'Owner B');

        $this->umkmRepository->deleteAll();

        $allUmkms = $this->umkmRepository->findAll();
        $this->assertEmpty($allUmkms);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM umkms");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $category = $this->createCategory();

        $umkm = new Umkm();
        $umkm->categoryId = $category->id;
        $umkm->name = '';
        $umkm->slug = '';
        $umkm->owner = '';
        $umkm->description = null;
        $umkm->address = null;
        $umkm->businessHours = null;
        $umkm->whatsapp = null;
        $umkm->mapsEmbedUrl = null;

        $savedUmkm = $this->umkmRepository->save($umkm);

        $this->assertNotNull($savedUmkm->id);
        $this->assertEquals('', $savedUmkm->name);
        $this->assertEquals('', $savedUmkm->slug);
        $this->assertEquals('', $savedUmkm->owner);

        $foundUmkm = $this->umkmRepository->findById($savedUmkm->id);
        $this->assertNotNull($foundUmkm);
        $this->assertEquals('', $foundUmkm->name);
        $this->assertEquals('', $foundUmkm->slug);
        $this->assertEquals('', $foundUmkm->owner);
        $this->assertNull($foundUmkm->description);
        $this->assertNull($foundUmkm->address);
    }
}