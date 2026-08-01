<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Umkm;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmCategory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmMenu;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmMenuRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class UmkmMenuRepositoryTest extends TestCase
{
    private PDO $pdo;
    private UmkmMenuRepository $menuRepository;
    private UmkmRepository $umkmRepository;
    private UmkmCategoryRepository $categoryRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->menuRepository = new UmkmMenuRepository($this->pdo);
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
        $this->menuRepository->deleteAll();
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
        ?UmkmCategory $category = null
    ): Umkm {
        if ($category === null) {
            $category = $this->createCategory();
        }

        $umkm = new Umkm();
        $umkm->categoryId = $category->id;
        $umkm->name = $name;
        $umkm->owner = $owner;
        $umkm->description = 'Deskripsi UMKM';
        $umkm->address = 'Jl. Raya Desa Bungur No. 1';
        $umkm->businessHours = '08:00 - 20:00';
        $umkm->whatsapp = '081234567890';

        return $this->umkmRepository->save($umkm);
    }

    private function createMenu(
        int $umkmId,
        string $name = 'Nasi Goreng',
        float $price = 15000,
        ?string $image = null
    ): UmkmMenu {
        $menu = new UmkmMenu();
        $menu->umkmId = $umkmId;
        $menu->name = $name;
        $menu->price = $price;
        $menu->image = $image;

        return $this->menuRepository->save($menu);
    }

    public function testSaveSuccess(): void
    {
        $umkm = $this->createUmkm();

        $menu = new UmkmMenu();
        $menu->umkmId = $umkm->id;
        $menu->name = 'Nasi Goreng Spesial';
        $menu->price = 25000;
        $menu->image = 'menu_123.jpg';

        $savedMenu = $this->menuRepository->save($menu);

        $this->assertNotNull($savedMenu->id);
        $this->assertIsInt($savedMenu->id);
        $this->assertEquals('Nasi Goreng Spesial', $savedMenu->name);
        $this->assertEquals(25000, $savedMenu->price);
        $this->assertEquals('menu_123.jpg', $savedMenu->image);
        $this->assertEquals($umkm->id, $savedMenu->umkmId);

        $foundMenu = $this->menuRepository->findById($savedMenu->id);
        $this->assertNotNull($foundMenu);
        $this->assertEquals('Nasi Goreng Spesial', $foundMenu->name);
        $this->assertEquals(25000, $foundMenu->price);
    }

    public function testUpdateSuccess(): void
    {
        $umkm = $this->createUmkm();
        $menu = $this->createMenu($umkm->id, 'Nasi Goreng', 15000);

        $menu->name = 'Nasi Goreng Special';
        $menu->price = 20000;
        $menu->image = 'menu_update.jpg';

        $updatedMenu = $this->menuRepository->update($menu);

        $this->assertEquals('Nasi Goreng Special', $updatedMenu->name);
        $this->assertEquals(20000, $updatedMenu->price);
        $this->assertEquals('menu_update.jpg', $updatedMenu->image);
        $this->assertNotNull($updatedMenu->updatedAt);

        $foundMenu = $this->menuRepository->findById($menu->id);
        $this->assertNotNull($foundMenu);
        $this->assertEquals('Nasi Goreng Special', $foundMenu->name);
        $this->assertEquals(20000, $foundMenu->price);
    }

    public function testFindByIdSuccess(): void
    {
        $umkm = $this->createUmkm();
        $menu = $this->createMenu($umkm->id, 'Mie Goreng', 12000);

        $foundMenu = $this->menuRepository->findById($menu->id);

        $this->assertNotNull($foundMenu);
        $this->assertEquals($menu->id, $foundMenu->id);
        $this->assertEquals('Mie Goreng', $foundMenu->name);
        $this->assertEquals(12000, $foundMenu->price);
        $this->assertEquals($umkm->id, $foundMenu->umkmId);
    }

    public function testFindByIdNotFound(): void
    {
        $foundMenu = $this->menuRepository->findById(99999);
        $this->assertNull($foundMenu);
    }

    public function testFindByUmkmIdSuccess(): void
    {
        $umkm = $this->createUmkm();

        $this->createMenu($umkm->id, 'Menu 1', 10000);
        $this->createMenu($umkm->id, 'Menu 2', 15000);
        $this->createMenu($umkm->id, 'Menu 3', 20000);

        $menus = $this->menuRepository->findByUmkmId($umkm->id);

        $this->assertCount(3, $menus);
        $this->assertEquals('Menu 1', $menus[0]->name);
        $this->assertEquals('Menu 2', $menus[1]->name);
        $this->assertEquals('Menu 3', $menus[2]->name);

        foreach ($menus as $menu) {
            $this->assertEquals($umkm->id, $menu->umkmId);
            $this->assertNotNull($menu->id);
            $this->assertNotEmpty($menu->name);
            $this->assertGreaterThan(0, $menu->price);
        }
    }

    public function testFindByUmkmIdEmpty(): void
    {
        $umkm = $this->createUmkm();

        $menus = $this->menuRepository->findByUmkmId($umkm->id);
        $this->assertEmpty($menus);
        $this->assertIsArray($menus);
    }

    public function testSoftDeleteSuccess(): void
    {
        $umkm = $this->createUmkm();
        $menu = $this->createMenu($umkm->id, 'Nasi Goreng', 15000);

        $foundMenu = $this->menuRepository->findById($menu->id);
        $this->assertNotNull($foundMenu);

        $this->menuRepository->softDelete($menu->id);

        $foundMenu = $this->menuRepository->findById($menu->id);
        $this->assertNull($foundMenu);

        $allMenus = $this->menuRepository->findByUmkmId($umkm->id);
        $this->assertEmpty($allMenus);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM umkm_menus WHERE id = ?");
        $statement->execute([$menu->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->menuRepository->softDelete(99999);

        $allMenus = $this->menuRepository->findByUmkmId(1);
        $this->assertEmpty($allMenus);
    }

    public function testDeleteByUmkmIdSuccess(): void
    {
        $umkm = $this->createUmkm();

        $this->createMenu($umkm->id, 'Menu 1', 10000);
        $this->createMenu($umkm->id, 'Menu 2', 15000);
        $this->createMenu($umkm->id, 'Menu 3', 20000);

        $menus = $this->menuRepository->findByUmkmId($umkm->id);
        $this->assertCount(3, $menus);

        $this->menuRepository->deleteByUmkmId($umkm->id);

        $menus = $this->menuRepository->findByUmkmId($umkm->id);
        $this->assertEmpty($menus);

        $statement = $this->pdo->prepare("SELECT COUNT(*) as count FROM umkm_menus WHERE umkm_id = ? AND deleted_at IS NOT NULL");
        $statement->execute([$umkm->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(3, (int) $row['count']);
    }

    public function testDeleteAllSuccess(): void
    {
        $umkm = $this->createUmkm();
        $this->createMenu($umkm->id, 'Menu 1', 10000);
        $this->createMenu($umkm->id, 'Menu 2', 15000);

        $this->menuRepository->deleteAll();

        $allMenus = $this->menuRepository->findByUmkmId($umkm->id);
        $this->assertEmpty($allMenus);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM umkm_menus");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $umkm = $this->createUmkm();

        $menu = new UmkmMenu();
        $menu->umkmId = $umkm->id;
        $menu->name = '';
        $menu->price = 0;
        $menu->image = null;

        $savedMenu = $this->menuRepository->save($menu);

        $this->assertNotNull($savedMenu->id);
        $this->assertEquals('', $savedMenu->name);
        $this->assertEquals(0, $savedMenu->price);
        $this->assertNull($savedMenu->image);

        $foundMenu = $this->menuRepository->findById($savedMenu->id);
        $this->assertNotNull($foundMenu);
        $this->assertEquals('', $foundMenu->name);
        $this->assertEquals(0, $foundMenu->price);
        $this->assertNull($foundMenu->image);
    }
}