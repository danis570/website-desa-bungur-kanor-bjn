<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCategoryCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCategoryUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\ArticleCategoryService;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleCategoryServiceTest extends TestCase
{
    private PDO $pdo;
    private ArticleCategoryService $service;
    private ArticleCategoryRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->repository = new ArticleCategoryRepository($this->pdo);
        $this->service = new ArticleCategoryService($this->repository);

        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->repository->deleteAll();
    }

    private function createCategory(string $name = 'Technology', string $slug = 'technology'): ArticleCategory
    {
        $category = new ArticleCategory();
        $category->name = $name;
        $category->slug = $slug;

        return $this->repository->save($category);
    }

    public function testCreateSuccess(): void
    {
        $request = new ArticleCategoryCreateRequest();
        $request->name = 'Programming';
        $request->slug = 'programming';

        $category = $this->service->create($request);

        $this->assertNotNull($category->id);
        $this->assertEquals('Programming', $category->name);
        $this->assertEquals('programming', $category->slug);

        $foundCategory = $this->service->findById($category->id);
        $this->assertNotNull($foundCategory);
        $this->assertEquals('Programming', $foundCategory->name);
    }

    public function testCreateValidationNameRequired(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama kategori wajib diisi');

        $request = new ArticleCategoryCreateRequest();
        $request->name = '';
        $request->slug = 'programming';

        $this->service->create($request);
    }

    public function testCreateValidationNameWithSpaces(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama kategori wajib diisi');

        $request = new ArticleCategoryCreateRequest();
        $request->name = '   ';
        $request->slug = 'programming';

        $this->service->create($request);
    }

    public function testCreateValidationSlugRequired(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug kategori wajib diisi');

        $request = new ArticleCategoryCreateRequest();
        $request->name = 'Programming';
        $request->slug = '';

        $this->service->create($request);
    }

    public function testCreateValidationSlugWithSpaces(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug kategori wajib diisi');

        $request = new ArticleCategoryCreateRequest();
        $request->name = 'Programming';
        $request->slug = '   ';

        $this->service->create($request);
    }

    public function testCreateValidationDuplicateName(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama kategori sudah digunakan');

        $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryCreateRequest();
        $request->name = 'Technology';
        $request->slug = 'tech';

        $this->service->create($request);
    }

    public function testCreateValidationDuplicateSlug(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug kategori sudah digunakan');

        $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryCreateRequest();
        $request->name = 'Tech';
        $request->slug = 'technology';

        $this->service->create($request);
    }

    public function testCreateTrimInput(): void
    {
        $request = new ArticleCategoryCreateRequest();
        $request->name = '  Programming  ';
        $request->slug = '  programming  ';

        $category = $this->service->create($request);

        $this->assertEquals('Programming', $category->name);
        $this->assertEquals('programming', $category->slug);
    }

    public function testUpdateSuccess(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = 'Programming';
        $request->slug = 'programming';

        $updatedCategory = $this->service->update($request);

        $this->assertEquals($category->id, $updatedCategory->id);
        $this->assertEquals('Programming', $updatedCategory->name);
        $this->assertEquals('programming', $updatedCategory->slug);

        $foundCategory = $this->service->findById($category->id);
        $this->assertNotNull($foundCategory);
        $this->assertEquals('Programming', $foundCategory->name);
        $this->assertEquals('programming', $foundCategory->slug);
    }

    public function testUpdateNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori tidak ditemukan');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = 99999;
        $request->name = 'Programming';
        $request->slug = 'programming';

        $this->service->update($request);
    }

    public function testUpdateValidationNameRequired(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama kategori wajib diisi');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = '';
        $request->slug = 'programming';

        $this->service->update($request);
    }

    public function testUpdateValidationSlugRequired(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug kategori wajib diisi');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = 'Programming';
        $request->slug = '';

        $this->service->update($request);
    }

    public function testUpdateValidationDuplicateName(): void
    {
        $this->createCategory('Technology', 'technology');
        $category2 = $this->createCategory('Programming', 'programming');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama kategori sudah digunakan');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category2->id;
        $request->name = 'Technology';
        $request->slug = 'programming';

        $this->service->update($request);
    }

    public function testUpdateValidationDuplicateSlug(): void
    {
        $this->createCategory('Technology', 'technology');
        $category2 = $this->createCategory('Programming', 'programming');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug kategori sudah digunakan');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category2->id;
        $request->name = 'Programming';
        $request->slug = 'technology';

        $this->service->update($request);
    }

    public function testUpdateKeepSameName(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = 'Technology';
        $request->slug = 'programming';

        $updatedCategory = $this->service->update($request);

        $this->assertEquals('Technology', $updatedCategory->name);
        $this->assertEquals('programming', $updatedCategory->slug);
    }

    public function testUpdateKeepSameSlug(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = 'Programming';
        $request->slug = 'technology';

        $updatedCategory = $this->service->update($request);

        $this->assertEquals('Programming', $updatedCategory->name);
        $this->assertEquals('technology', $updatedCategory->slug);
    }

    public function testUpdateTrimInput(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $request = new ArticleCategoryUpdateRequest();
        $request->id = $category->id;
        $request->name = '  Programming  ';
        $request->slug = '  programming  ';

        $updatedCategory = $this->service->update($request);

        $this->assertEquals('Programming', $updatedCategory->name);
        $this->assertEquals('programming', $updatedCategory->slug);
    }

    public function testDeleteSuccess(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $this->service->delete($category->id);

        $foundCategory = $this->service->findById($category->id);
        $this->assertNull($foundCategory);

        $allCategories = $this->service->findAll();
        $this->assertEmpty($allCategories);
    }

    public function testDeleteNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Kategori tidak ditemukan');

        $this->service->delete(99999);
    }

    public function testFindByIdSuccess(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $foundCategory = $this->service->findById($category->id);

        $this->assertNotNull($foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
        $this->assertEquals('Technology', $foundCategory->name);
        $this->assertEquals('technology', $foundCategory->slug);
    }

    public function testFindByIdNotFound(): void
    {
        $foundCategory = $this->service->findById(99999);
        $this->assertNull($foundCategory);
    }

    public function testFindBySlugSuccess(): void
    {
        $this->createCategory('Technology', 'technology');

        $foundCategory = $this->service->findBySlug('technology');

        $this->assertNotNull($foundCategory);
        $this->assertEquals('Technology', $foundCategory->name);
        $this->assertEquals('technology', $foundCategory->slug);
    }

    public function testFindBySlugNotFound(): void
    {
        $foundCategory = $this->service->findBySlug('non-existent');
        $this->assertNull($foundCategory);
    }

    public function testFindByNameSuccess(): void
    {
        $this->createCategory('Technology', 'technology');

        $foundCategory = $this->service->findByName('Technology');

        $this->assertNotNull($foundCategory);
        $this->assertEquals('Technology', $foundCategory->name);
        $this->assertEquals('technology', $foundCategory->slug);
    }

    public function testFindByNameNotFound(): void
    {
        $foundCategory = $this->service->findByName('Non Existent');
        $this->assertNull($foundCategory);
    }

    public function testFindAllSuccess(): void
    {
        $this->createCategory('Category A', 'category-a');
        $this->createCategory('Category B', 'category-b');
        $this->createCategory('Category C', 'category-c');

        $categories = $this->service->findAll();

        $this->assertCount(3, $categories);
        $this->assertEquals('Category A', $categories[0]->name);
        $this->assertEquals('Category B', $categories[1]->name);
        $this->assertEquals('Category C', $categories[2]->name);
    }

    public function testFindAllEmpty(): void
    {
        $categories = $this->service->findAll();
        $this->assertEmpty($categories);
    }

    public function testDeleteSoftDeleteSetDeletedAt(): void
    {
        $category = $this->createCategory('Technology', 'technology');

        $this->service->delete($category->id);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM article_categories WHERE id = ?");
        $statement->execute([$category->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->assertNotNull($row);
        $this->assertNotNull($row['deleted_at']);
    }

    public function testCreateMultipleCategories(): void
    {
        $request1 = new ArticleCategoryCreateRequest();
        $request1->name = 'Category 1';
        $request1->slug = 'category-1';
        $category1 = $this->service->create($request1);

        $request2 = new ArticleCategoryCreateRequest();
        $request2->name = 'Category 2';
        $request2->slug = 'category-2';
        $category2 = $this->service->create($request2);

        $this->assertNotNull($category1->id);
        $this->assertNotNull($category2->id);
        $this->assertNotEquals($category1->id, $category2->id);

        $categories = $this->service->findAll();
        $this->assertCount(2, $categories);
    }
}