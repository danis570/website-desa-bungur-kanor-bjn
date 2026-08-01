<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmCategory;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class UmkmCategoryRepositoryTest extends TestCase
{
    private PDO $pdo;
    private UmkmCategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
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

    public function testFindAllSuccess(): void
{
    $this->createCategory('Makanan', 'makanan');
    $this->createCategory('Minuman', 'minuman');
    $this->createCategory('Kerajinan', 'kerajinan');

    $categories = $this->categoryRepository->findAll();

    $this->assertCount(3, $categories);
    // Urutan: Kerajinan, Makanan, Minuman (ASC)
    $this->assertEquals('Kerajinan', $categories[0]->name);
    $this->assertEquals('Makanan', $categories[1]->name);
    $this->assertEquals('Minuman', $categories[2]->name);

    foreach ($categories as $category) {
        $this->assertNotNull($category->id);
        $this->assertNotEmpty($category->name);
        $this->assertNotEmpty($category->slug);
    }
}

    public function testFindAllEmpty(): void
    {
        $categories = $this->categoryRepository->findAll();
        $this->assertEmpty($categories);
        $this->assertIsArray($categories);
    }

    public function testFindByIdSuccess(): void
    {
        $category = $this->createCategory('Makanan', 'makanan');

        $foundCategory = $this->categoryRepository->findById($category->id);

        $this->assertNotNull($foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals('Makanan', $foundCategory->name);
        $this->assertEquals('makanan', $foundCategory->slug);
    }

    public function testFindByIdNotFound(): void
    {
        $foundCategory = $this->categoryRepository->findById(99999);
        $this->assertNull($foundCategory);
    }
}