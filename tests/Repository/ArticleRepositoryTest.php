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
        string $status = 'published'
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
        $article->content = 'This is test content.';

        return $this->articleRepository->save($article);
    }

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
        $article->content = 'Content for new article.';

        $savedArticle = $this->articleRepository->save($article);

        $this->assertNotNull($savedArticle->id);
        $this->assertIsInt($savedArticle->id);
        $this->assertEquals('New Article', $savedArticle->title);
        $this->assertEquals('new-article', $savedArticle->slug);
        $this->assertEquals($user->id, $savedArticle->userId);
        $this->assertEquals($category->id, $savedArticle->categoryId);
        $this->assertEquals('published', $savedArticle->status);

        $foundArticle = $this->articleRepository->findById($savedArticle->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('New Article', $foundArticle->title);
        $this->assertEquals('new-article', $foundArticle->slug);
    }

    public function testUpdateSuccess(): void
    {
        $article = $this->createArticle('Original Title', 'original-slug');

        $article->title = 'Updated Title';
        $article->slug = 'updated-slug';
        $article->excerpt = 'Updated excerpt';
        $article->content = 'Updated content.';
        $article->status = 'draft';

        $updatedArticle = $this->articleRepository->update($article);

        $this->assertEquals('Updated Title', $updatedArticle->title);
        $this->assertEquals('updated-slug', $updatedArticle->slug);
        $this->assertEquals('draft', $updatedArticle->status);

        $foundArticle = $this->articleRepository->findById($article->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('Updated Title', $foundArticle->title);
        $this->assertEquals('updated-slug', $foundArticle->slug);
        $this->assertEquals('draft', $foundArticle->status);
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
    }

    public function testFindByIdNotFound(): void
    {
        $foundArticle = $this->articleRepository->findById(99999);
        $this->assertNull($foundArticle);
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
    }

    public function testFindBySlugNotFound(): void
    {
        $foundArticle = $this->articleRepository->findBySlug('non-existent-slug');
        $this->assertNull($foundArticle);
    }

    public function testFindAllSuccess(): void
    {
        $this->createArticle('First Article', 'first-article');
        $this->createArticle('Second Article', 'second-article');
        $this->createArticle('Third Article', 'third-article');

        $articles = $this->articleRepository->findAll();

        $this->assertCount(3, $articles);
        $this->assertEquals('Third Article', $articles[0]->title);
        $this->assertEquals('Second Article', $articles[1]->title);
        $this->assertEquals('First Article', $articles[2]->title);

        foreach ($articles as $article) {
            $this->assertNotEmpty($article->authorName);
            $this->assertNotEmpty($article->categoryName);
        }
    }

    public function testFindAllEmpty(): void
    {
        $articles = $this->articleRepository->findAll();
        $this->assertEmpty($articles);
        $this->assertIsArray($articles);
    }

    public function testFindPublishedSuccess(): void
    {
        $this->createArticle('Published Article 1', 'published-1', null, null, 'published');
        $this->createArticle('Published Article 2', 'published-2', null, null, 'published');
        $this->createArticle('Draft Article', 'draft-article', null, null, 'draft');
        $this->createArticle('Archived Article', 'archived-article', null, null, 'archived');

        $publishedArticles = $this->articleRepository->findPublished();

        $this->assertCount(2, $publishedArticles);
        $this->assertEquals('published', $publishedArticles[0]->status);
        $this->assertEquals('published', $publishedArticles[1]->status);
        $this->assertTrue($publishedArticles[0]->publishedAt >= $publishedArticles[1]->publishedAt);
    }

    public function testFindPublishedEmpty(): void
    {
        $this->createArticle('Draft Article', 'draft-article', null, null, 'draft');
        $this->createArticle('Archived Article', 'archived-article', null, null, 'archived');

        $publishedArticles = $this->articleRepository->findPublished();
        $this->assertEmpty($publishedArticles);
        $this->assertIsArray($publishedArticles);
    }

    public function testFindByUserIdSuccess(): void
    {
        $user1 = $this->createUser('User One', 'user1@example.com');
        $user2 = $this->createUser('User Two', 'user2@example.com');

        $category = $this->createCategory();

        $this->createArticle('User1 Article 1', 'user1-1', $user1, $category);
        $this->createArticle('User1 Article 2', 'user1-2', $user1, $category);
        $this->createArticle('User2 Article', 'user2-1', $user2, $category);

        $user1Articles = $this->articleRepository->findByUserId($user1->id);

        $this->assertCount(2, $user1Articles);
        $this->assertEquals($user1->id, $user1Articles[0]->userId);
        $this->assertEquals($user1->id, $user1Articles[1]->userId);
        $this->assertEquals('User One', $user1Articles[0]->authorName);

        $user2Articles = $this->articleRepository->findByUserId($user2->id);
        $this->assertCount(1, $user2Articles);
        $this->assertEquals($user2->id, $user2Articles[0]->userId);
        $this->assertEquals('User Two', $user2Articles[0]->authorName);
    }

    public function testFindByUserIdEmpty(): void
    {
        $user = $this->createUser('Empty User', 'empty@example.com');

        $articles = $this->articleRepository->findByUserId($user->id);
        $this->assertEmpty($articles);
        $this->assertIsArray($articles);
    }

    public function testSoftDeleteSuccess(): void
    {
        $article = $this->createArticle('Delete Me', 'delete-me');

        $foundArticle = $this->articleRepository->findById($article->id);
        $this->assertNotNull($foundArticle);

        $this->articleRepository->softDelete($article->id);

        $foundArticle = $this->articleRepository->findById($article->id);
        $this->assertNull($foundArticle);

        $allArticles = $this->articleRepository->findAll();
        $this->assertEmpty($allArticles);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM articles WHERE id = ?");
        $statement->execute([$article->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->articleRepository->softDelete(99999);

        $allArticles = $this->articleRepository->findAll();
        $this->assertEmpty($allArticles);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createArticle('Article 1', 'article-1');
        $this->createArticle('Article 2', 'article-2');

        $this->articleRepository->deleteAll();

        $allArticles = $this->articleRepository->findAll();
        $this->assertEmpty($allArticles);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM articles");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->assertEquals(0, (int) $row['count']);
    }

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
        $article->content = '';

        $savedArticle = $this->articleRepository->save($article);

        $this->assertNotNull($savedArticle->id);
        $this->assertEquals('', $savedArticle->title);
        $this->assertEquals('empty-title', $savedArticle->slug);

        $foundArticle = $this->articleRepository->findById($savedArticle->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals('', $foundArticle->title);
        $this->assertNull($foundArticle->publishedAt);
        $this->assertNull($foundArticle->image);
    }
}