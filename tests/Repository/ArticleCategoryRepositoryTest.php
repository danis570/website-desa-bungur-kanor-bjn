<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleCategoryRepositoryTest extends TestCase
{
    private ArticleCategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->categoryRepository = new ArticleCategoryRepository($this->pdo);
        $this->userRepository = new UserRepository($this->pdo);

        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->categoryRepository->deleteAll();
        $this->userRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createCategory(string $name = 'Technology', string $slug = 'technology'): ArticleCategory
    {
        $category = new ArticleCategory();
        $category->name = $name;
        $category->slug = $slug;

        return $this->categoryRepository->save($category);
    }

    public function testSaveSuccess(): void
    {
        $category = new ArticleCategory();
        $category->name = 'New Category';
        $category->slug = 'new-category';

        $savedCategory = $this->categoryRepository->save($category);

        $this->assertNotNull($savedCategory->id);
        $this->assertEquals('New Category', $savedCategory->name);
        $this->assertEquals('new-category', $savedCategory->slug);

        $foundCategory = $this->categoryRepository->findById($savedCategory->id);
        $this->assertNotNull($foundCategory);
        $this->assertEquals('New Category', $foundCategory->name);
    }

    public function testSaveWithExistingData(): void
    {
        $category1 = new ArticleCategory();
        $category1->name = 'Category One';
        $category1->slug = 'category-one';
        $this->categoryRepository->save($category1);

        $category2 = new ArticleCategory();
        $category2->name = 'Category Two';
        $category2->slug = 'category-two';
        $savedCategory2 = $this->categoryRepository->save($category2);

        $this->assertNotNull($savedCategory2->id);
        $this->assertEquals('Category Two', $savedCategory2->name);
    }

    public function testUpdateSuccess(): void
    {
        $category = $this->createCategory('Original Name', 'original-slug');

        $category->name = 'Updated Name';
        $category->slug = 'updated-slug';

        $updatedCategory = $this->categoryRepository->update($category);

        $this->assertEquals('Updated Name', $updatedCategory->name);
        $this->assertEquals('updated-slug', $updatedCategory->slug);

        $foundCategory = $this->categoryRepository->findById($category->id);
        $this->assertNotNull($foundCategory);
        $this->assertEquals('Updated Name', $foundCategory->name);
        $this->assertEquals('updated-slug', $foundCategory->slug);
    }

    public function testFindByIdSuccess(): void
    {
        $category = $this->createCategory('Find By ID', 'find-by-id');

        $foundCategory = $this->categoryRepository->findById($category->id);

        $this->assertNotNull($foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals('Find By ID', $foundCategory->name);
        $this->assertEquals('find-by-id', $foundCategory->slug);
    }

    public function testFindByIdNotFound(): void
    {
        $foundCategory = $this->categoryRepository->findById(99999);
        $this->assertNull($foundCategory);
    }

    public function testFindBySlugSuccess(): void
    {
        $category = $this->createCategory('Find By Slug', 'find-by-slug');

        $foundCategory = $this->categoryRepository->findBySlug('find-by-slug');

        $this->assertNotNull($foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals('Find By Slug', $foundCategory->name);
        $this->assertEquals('find-by-slug', $foundCategory->slug);
    }

    public function testFindBySlugNotFound(): void
    {
        $foundCategory = $this->categoryRepository->findBySlug('non-existent-slug');
        $this->assertNull($foundCategory);
    }

    public function testFindByNameSuccess(): void
    {
        $category = $this->createCategory('Find By Name', 'find-by-name');

        $foundCategory = $this->categoryRepository->findByName('Find By Name');

        $this->assertNotNull($foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals('Find By Name', $foundCategory->name);
        $this->assertEquals('find-by-name', $foundCategory->slug);
    }

    public function testFindByNameNotFound(): void
    {
        $foundCategory = $this->categoryRepository->findByName('Non Existent Name');
        $this->assertNull($foundCategory);
    }

    public function testFindAllSuccess(): void
    {
        $this->createCategory('Category A', 'category-a');
        $this->createCategory('Category B', 'category-b');
        $this->createCategory('Category C', 'category-c');

        $categories = $this->categoryRepository->findAll();

        $this->assertCount(3, $categories);
        $this->assertEquals('Category A', $categories[0]->name);
        $this->assertEquals('Category B', $categories[1]->name);
        $this->assertEquals('Category C', $categories[2]->name);
    }

    public function testFindAllEmpty(): void
    {
        $categories = $this->categoryRepository->findAll();
        $this->assertEmpty($categories);
    }

    public function testSoftDeleteSuccess(): void
    {
        $category = $this->createCategory('Delete Me', 'delete-me');

        $this->categoryRepository->softDelete($category->id);

        $foundCategory = $this->categoryRepository->findById($category->id);
        $this->assertNull($foundCategory);

        $allCategories = $this->categoryRepository->findAll();
        $this->assertEmpty($allCategories);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->categoryRepository->softDelete(99999);

        $allCategories = $this->categoryRepository->findAll();
        $this->assertEmpty($allCategories);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createCategory('Category 1', 'category-1');
        $this->createCategory('Category 2', 'category-2');

        $this->categoryRepository->deleteAll();

        $allCategories = $this->categoryRepository->findAll();
        $this->assertEmpty($allCategories);
    }

    public function testFindAllOrdering(): void
    {
        $this->createCategory('Zoo', 'zoo');
        $this->createCategory('Alpha', 'alpha');
        $this->createCategory('Beta', 'beta');

        $categories = $this->categoryRepository->findAll();

        $this->assertCount(3, $categories);
        $this->assertEquals('Alpha', $categories[0]->name);
        $this->assertEquals('Beta', $categories[1]->name);
        $this->assertEquals('Zoo', $categories[2]->name);
    }
}