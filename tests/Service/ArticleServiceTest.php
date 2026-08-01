<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Article;
use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\ArticleService;
use PDO;
use PHPUnit\Framework\TestCase;

class ArticleServiceTest extends TestCase
{
    private PDO $pdo;
    private ArticleService $articleService;
    private ArticleRepository $articleRepository;
    private ArticleCategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private int $userCounter = 0;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->articleRepository = new ArticleRepository($this->pdo);
        $this->categoryRepository = new ArticleCategoryRepository($this->pdo);
        $this->userRepository = new UserRepository($this->pdo);

        $this->articleService = new ArticleService(
            $this->articleRepository,
            $this->categoryRepository
        );

        $this->cleanupDatabase();
        $this->userCounter = 0;
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

    private function createUser(string $name = 'Test User'): User
    {
        $this->userCounter++;
        $email = "test{$this->userCounter}@example.com";

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = password_hash('password123', PASSWORD_DEFAULT);

        return $this->userRepository->save($user);
    }

    private function createCategory(string $name = 'Technology', string $slug = 'technology'): ArticleCategory
    {
        $category = new ArticleCategory();
        $category->name = $name;
        $category->slug = $slug;

        return $this->categoryRepository->save($category);
    }

    public function testCreateSuccess(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'My First Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = '<p>This is the content of my first article.</p>';
        $request->status = 'published';
        $request->image = 'image.jpg';

        $article = $this->articleService->create($request);

        $this->assertNotNull($article->id);
        $this->assertEquals('My First Article', $article->title);
        $this->assertEquals('my-first-article', $article->slug);
        $this->assertEquals($user->id, $article->userId);
        $this->assertEquals($category->id, $article->categoryId);
        $this->assertEquals('This is the content of my first article.', $article->excerpt);
        $this->assertEquals('published', $article->status);
        $this->assertNotNull($article->publishedAt);
        $this->assertEquals('image.jpg', $article->image);
        $this->assertEquals('<p>This is the content of my first article.</p>', $article->content);
    }

    public function testCreateWithEmptyExcerpt(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = '<p>This is a long content that should be truncated to 200 characters. ' .
            'This is a long content that should be truncated to 200 characters. ' .
            'This is a long content that should be truncated to 200 characters. ' .
            'This is a long content that should be truncated to 200 characters.</p>';
        $request->status = 'draft';

        $article = $this->articleService->create($request);

        $this->assertNotNull($article->id);
        $this->assertNotEmpty($article->excerpt);
        $this->assertLessThanOrEqual(203, strlen($article->excerpt));
        $this->assertNull($article->publishedAt);
    }

    public function testCreateWithCustomExcerpt(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = '<p>This is the content.</p>';
        $request->excerpt = 'Custom excerpt';
        $request->status = 'draft';

        $article = $this->articleService->create($request);

        $this->assertEquals('Custom excerpt', $article->excerpt);
    }

    public function testCreateValidationTitleRequired(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Title is required');

        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = '';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';

        $this->articleService->create($request);
    }

    public function testCreateValidationCategoryRequired(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Category is required');

        $user = $this->createUser();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = 0;
        $request->content = 'Content';
        $request->status = 'draft';

        $this->articleService->create($request);
    }

    public function testCreateValidationCategoryNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Category not found');

        $user = $this->createUser();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = 99999;
        $request->content = 'Content';
        $request->status = 'draft';

        $this->articleService->create($request);
    }

    public function testCreateValidationContentRequired(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Content is required');

        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = '';
        $request->status = 'draft';

        $this->articleService->create($request);
    }

    public function testCreateValidationInvalidStatus(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Status must be draft or published');

        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Test Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'invalid';

        $this->articleService->create($request);
    }

    public function testCreateValidationDuplicateSlug(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug already used by another article');

        $user = $this->createUser();
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'Test Article';
        $request1->userId = $user->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'draft';
        $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'Test Article';
        $request2->userId = $user->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'draft';

        $this->articleService->create($request2);
    }

    public function testUpdateSuccess(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Original Title';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Original content';
        $request->status = 'draft';
        $article = $this->articleService->create($request);

        $updateRequest = new ArticleUpdateRequest();
        $updateRequest->id = $article->id;
        $updateRequest->title = 'Updated Title';
        $updateRequest->categoryId = $category->id;
        $updateRequest->content = 'Updated content';
        $updateRequest->status = 'published';
        $updateRequest->image = 'updated-image.jpg';

        $updatedArticle = $this->articleService->update($updateRequest);

        $this->assertEquals('Updated Title', $updatedArticle->title);
        $this->assertEquals('updated-title', $updatedArticle->slug);
        $this->assertEquals($category->id, $updatedArticle->categoryId);
        $this->assertEquals('Updated content', $updatedArticle->content);
        $this->assertEquals('published', $updatedArticle->status);
        $this->assertNotNull($updatedArticle->publishedAt);
        $this->assertEquals('updated-image.jpg', $updatedArticle->image);
    }

    public function testUpdateNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Article not found');

        $category = $this->createCategory();

        $request = new ArticleUpdateRequest();
        $request->id = 99999;
        $request->title = 'Updated Title';
        $request->categoryId = $category->id;
        $request->content = 'Updated content';
        $request->status = 'draft';

        $this->articleService->update($request);
    }

    public function testUpdateDuplicateSlug(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'First Article';
        $request1->userId = $user->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'draft';
        $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'Second Article';
        $request2->userId = $user->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'draft';
        $article2 = $this->articleService->create($request2);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Slug already used by another article');

        $updateRequest = new ArticleUpdateRequest();
        $updateRequest->id = $article2->id;
        $updateRequest->title = 'First Article';
        $updateRequest->categoryId = $category->id;
        $updateRequest->content = 'Updated content';
        $updateRequest->status = 'draft';

        $this->articleService->update($updateRequest);
    }

    public function testDeleteSuccess(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Delete Me';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';
        $article = $this->articleService->create($request);

        $this->articleService->delete($article->id);

        $foundArticle = $this->articleService->findById($article->id);
        $this->assertNull($foundArticle);
    }

    public function testDeleteNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Article not found');

        $this->articleService->delete(99999);
    }

    public function testFindAll(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'Article 1';
        $request1->userId = $user->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'draft';
        $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'Article 2';
        $request2->userId = $user->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'published';
        $this->articleService->create($request2);

        $articles = $this->articleService->findAll();

        $this->assertCount(2, $articles);
        $this->assertEquals('Article 2', $articles[0]->title);
        $this->assertEquals('Article 1', $articles[1]->title);
    }

    public function testFindPublished(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'Published 1';
        $request1->userId = $user->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'published';
        $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'Draft';
        $request2->userId = $user->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'draft';
        $this->articleService->create($request2);

        $request3 = new ArticleCreateRequest();
        $request3->title = 'Published 2';
        $request3->userId = $user->id;
        $request3->categoryId = $category->id;
        $request3->content = 'Content 3';
        $request3->status = 'published';
        $this->articleService->create($request3);

        $publishedArticles = $this->articleService->findPublished();

        $this->assertCount(2, $publishedArticles);
        $this->assertEquals('published', $publishedArticles[0]->status);
        $this->assertEquals('published', $publishedArticles[1]->status);
    }

    public function testFindByUserId(): void
    {
        $user1 = $this->createUser('User One');
        $user2 = $this->createUser('User Two');
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'User1 Article';
        $request1->userId = $user1->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'draft';
        $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'User2 Article';
        $request2->userId = $user2->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'draft';
        $this->articleService->create($request2);

        $user1Articles = $this->articleService->findByUserId($user1->id);
        $this->assertCount(1, $user1Articles);
        $this->assertEquals($user1->id, $user1Articles[0]->userId);

        $user2Articles = $this->articleService->findByUserId($user2->id);
        $this->assertCount(1, $user2Articles);
        $this->assertEquals($user2->id, $user2Articles[0]->userId);
    }

    public function testFindById(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Find Me';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';
        $article = $this->articleService->create($request);

        $foundArticle = $this->articleService->findById($article->id);
        $this->assertNotNull($foundArticle);
        $this->assertEquals($article->id, $foundArticle->id);
        $this->assertEquals('Find Me', $foundArticle->title);
    }

    public function testFindByIdNotFound(): void
    {
        $foundArticle = $this->articleService->findById(99999);
        $this->assertNull($foundArticle);
    }

    public function testFindBySlug(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Find By Slug';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';
        $this->articleService->create($request);

        $foundArticle = $this->articleService->findBySlug('find-by-slug');
        $this->assertNotNull($foundArticle);
        $this->assertEquals('Find By Slug', $foundArticle->title);
    }

    public function testFindBySlugNotFound(): void
    {
        $foundArticle = $this->articleService->findBySlug('non-existent');
        $this->assertNull($foundArticle);
    }

    public function testGenerateSlugWithSpecialCharacters(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'My Article with Special Characters! @#$%^&*()';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';

        $article = $this->articleService->create($request);

        $this->assertEquals('my-article-with-special-characters', $article->slug);
    }

    public function testGenerateExcerptWithHtml(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Test';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = '<p>This is a <strong>paragraph</strong> with <em>formatting</em>.</p>';
        $request->status = 'draft';

        $article = $this->articleService->create($request);

        $this->assertEquals('This is a paragraph with formatting.', $article->excerpt);
    }

    public function testPublishedAtNullForDraft(): void
    {
        $user = $this->createUser();
        $category = $this->createCategory();

        $request = new ArticleCreateRequest();
        $request->title = 'Draft Article';
        $request->userId = $user->id;
        $request->categoryId = $category->id;
        $request->content = 'Content';
        $request->status = 'draft';

        $article = $this->articleService->create($request);

        $this->assertNull($article->publishedAt);
    }

    public function testCreateMultipleArticlesByDifferentUsers(): void
    {
        $user1 = $this->createUser('User One');
        $user2 = $this->createUser('User Two');
        $category = $this->createCategory();

        $request1 = new ArticleCreateRequest();
        $request1->title = 'Article by User 1';
        $request1->userId = $user1->id;
        $request1->categoryId = $category->id;
        $request1->content = 'Content 1';
        $request1->status = 'published';
        $article1 = $this->articleService->create($request1);

        $request2 = new ArticleCreateRequest();
        $request2->title = 'Article by User 2';
        $request2->userId = $user2->id;
        $request2->categoryId = $category->id;
        $request2->content = 'Content 2';
        $request2->status = 'published';
        $article2 = $this->articleService->create($request2);

        $this->assertNotEquals($article1->userId, $article2->userId);
        $this->assertEquals($user1->id, $article1->userId);
        $this->assertEquals($user2->id, $article2->userId);
    }
}