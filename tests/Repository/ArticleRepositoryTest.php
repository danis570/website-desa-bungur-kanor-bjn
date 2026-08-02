<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Article;
use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleRepositoryTest extends TestCase
{
    private PDO $pdo;
    private ArticleRepository $articleRepository;
    private ArticleCategoryRepository $categoryRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->articleRepository = new ArticleRepository($this->pdo);
        $this->categoryRepository = new ArticleCategoryRepository($this->pdo);
        $this->userRepository = new UserRepository($this->pdo);

        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->articleRepository->deleteAll();
        $this->categoryRepository->deleteAll();
        $this->userRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createUser(
        string $name = 'Test User',
        ?string $email = null
    ): User {

        $user = new User();

        $user->name = $name;

        $user->email = $email
            ?? 'test' . uniqid() . '@example.com';

        $user->password = password_hash(
            'password123',
            PASSWORD_DEFAULT
        );

        $user->role = 'user';

        return $this->userRepository->save($user);
    }

    private function createCategory(
        string $name = 'Technology',
        ?string $slug = null
    ): ArticleCategory {
        $category = new ArticleCategory();
        $category->name = $name;
        $category->slug = $slug ?? 'technology-' . uniqid();

        return $this->categoryRepository->save($category);
    }

    private function createArticle(
        string $title = 'Test Article',
        string $slug = 'test-article',
        ?User $user = null,
        ?ArticleCategory $category = null,
        string $status = 'published',
        ?string $imageAlt = null
    ): Article {
        if ($user === null) {
            $user = $this->createUser();
        }

        if ($category === null) {
            $category = $this->createCategory();
        }

        $article = new Article();
        $article->title = $title;
        $article->slug = $slug;
        $article->userId = $user->id;
        $article->categoryId = $category->id;
        $article->excerpt = 'This is a test excerpt';
        $article->status = $status;
        $article->publishedAt = date('Y-m-d H:i:s');
        $article->image = 'test-image.jpg';
        $article->imageAlt = $imageAlt ?? 'Alt text for ' . $title;
        $article->content = 'This is test content.';

        return $this->articleRepository->save($article);
    }

    // ... test lainnya ...

    public function testSaveSuccess(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $article = new Article();
        $article->title = 'New Article';
        $article->slug = 'new-article';
        $article->userId = $user->id;
        $article->categoryId = $category->id;
        $article->excerpt = 'Excerpt for new article';
        $article->status = 'published';
        $article->publishedAt = date('Y-m-d H:i:s');
        $article->image = 'new-image.jpg';
        $article->imageAlt = 'Alt text for new article';
        $article->content = 'Content for new article.';

        $savedArticle = $this->articleRepository->save($article);

        $this->assertNotNull($savedArticle->id);
        $this->assertIsInt($savedArticle->id);
        $this->assertEquals('New Article', $savedArticle->title);
        $this->assertEquals('new-article', $savedArticle->slug);
        $this->assertEquals($user->id, $savedArticle->userId);
        $this->assertEquals($category->id, $savedArticle->categoryId);
        $this->assertEquals('published', $savedArticle->status);
        $this->assertEquals('Alt text for new article', $savedArticle->imageAlt);

        $foundArticle = $this->articleRepository->findById($savedArticle->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('New Article', $foundArticle->title);
        $this->assertEquals('new-article', $foundArticle->slug);
        $this->assertEquals('Alt text for new article', $foundArticle->imageAlt);
    }

    public function testUpdateSuccess(): void
    {
        $article = $this->createArticle('Original Title', 'original-slug');

        $article->title = 'Updated Title';
        $article->slug = 'updated-slug';
        $article->excerpt = 'Updated excerpt';
        $article->content = 'Updated content.';
        $article->status = 'draft';
        $article->imageAlt = 'Updated alt text';

        $updatedArticle = $this->articleRepository->update($article);

        $this->assertEquals('Updated Title', $updatedArticle->title);
        $this->assertEquals('updated-slug', $updatedArticle->slug);
        $this->assertEquals('draft', $updatedArticle->status);
        $this->assertEquals('Updated alt text', $updatedArticle->imageAlt);

        $foundArticle = $this->articleRepository->findById($article->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('Updated Title', $foundArticle->title);
        $this->assertEquals('updated-slug', $foundArticle->slug);
        $this->assertEquals('draft', $foundArticle->status);
        $this->assertEquals('Updated alt text', $foundArticle->imageAlt);
        $this->assertNotNull($foundArticle->updatedAt);
    }

    public function testFindByIdSuccess(): void
    {
        $article = $this->createArticle('Find By ID Test', 'find-by-id-test');

        $foundArticle = $this->articleRepository->findById($article->id);

        $this->assertNotNull($foundArticle);
        $this->assertEquals($article->id, $foundArticle->id);
        $this->assertEquals('Find By ID Test', $foundArticle->title);
        $this->assertEquals('find-by-id-test', $foundArticle->slug);
        $this->assertNotEmpty($foundArticle->authorName);
        $this->assertNotEmpty($foundArticle->categoryName);
        $this->assertEquals('Test User', $foundArticle->authorName);
        $this->assertEquals('Technology', $foundArticle->categoryName);
        $this->assertEquals('Alt text for Find By ID Test', $foundArticle->imageAlt);
    }

    public function testFindBySlugSuccess(): void
    {
        $article = $this->createArticle('Find By Slug Test', 'find-by-slug-test');

        $foundArticle = $this->articleRepository->findBySlug('find-by-slug-test');

        $this->assertNotNull($foundArticle);
        $this->assertEquals($article->id, $foundArticle->id);
        $this->assertEquals('Find By Slug Test', $foundArticle->title);
        $this->assertEquals('find-by-slug-test', $foundArticle->slug);
        $this->assertNotEmpty($foundArticle->authorName);
        $this->assertNotEmpty($foundArticle->categoryName);
        $this->assertEquals('Alt text for Find By Slug Test', $foundArticle->imageAlt);
    }

    // ... test lainnya ...

    public function testSaveWithEmptyFields(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $article = new Article();
        $article->title = '';
        $article->slug = 'empty-title';
        $article->userId = $user->id;
        $article->categoryId = $category->id;
        $article->excerpt = '';
        $article->status = 'draft';
        $article->publishedAt = null;
        $article->image = null;
        $article->imageAlt = null;
        $article->content = '';

        $savedArticle = $this->articleRepository->save($article);

        $this->assertNotNull($savedArticle->id);
        $this->assertEquals('', $savedArticle->title);
        $this->assertEquals('empty-title', $savedArticle->slug);
        $this->assertNull($savedArticle->imageAlt);

        $foundArticle = $this->articleRepository->findById($savedArticle->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('', $foundArticle->title);
        $this->assertNull($foundArticle->publishedAt);
        $this->assertNull($foundArticle->image);
        $this->assertNull($foundArticle->imageAlt);
    }

    public function testSaveWithImageAlt(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $article = new Article();
        $article->title = 'Article with Image Alt';
        $article->slug = 'article-with-image-alt';
        $article->userId = $user->id;
        $article->categoryId = $category->id;
        $article->excerpt = 'Excerpt';
        $article->status = 'published';
        $article->publishedAt = date('Y-m-d H:i:s');
        $article->image = 'article-image.jpg';
        $article->imageAlt = 'Deskripsi gambar artikel ini';
        $article->content = 'Content';

        $savedArticle = $this->articleRepository->save($article);

        $this->assertNotNull($savedArticle->id);
        $this->assertEquals('Deskripsi gambar artikel ini', $savedArticle->imageAlt);

        $foundArticle = $this->articleRepository->findById($savedArticle->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('Deskripsi gambar artikel ini', $foundArticle->imageAlt);
    }
}