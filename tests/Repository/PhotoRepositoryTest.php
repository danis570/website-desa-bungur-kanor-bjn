<?php
namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Photo;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use PDO;
use PHPUnit\Framework\TestCase;
class PhotoRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PhotoRepository $photoRepository;
    private UserRepository $userRepository;
    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->photoRepository = new PhotoRepository($this->pdo);
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
        $this->photoRepository->deleteAll();
        $this->userRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
    private function createUser(string $name = 'Test User', ?string $email = null): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email ?? 'test' . uniqid() . '@example.com';
        $user->password = password_hash('password123', PASSWORD_DEFAULT);
        $user->role = 'user';
        return $this->userRepository->save($user);
    }
    private function createPhoto(string $caption = 'Test Photo', string $location = 'Test Location', ?User $user = null): Photo
    {
        if ($user === null) {
            $user = $this->createUser();
        }
        $photo = new Photo();
        $photo->caption = $caption;
        $photo->location = $location;
        $photo->userId = $user->id;
        return $this->photoRepository->save($photo);
    }
    public function testSaveSuccess(): void
    {
        $user = $this->createUser();
        $photo = new Photo();
        $photo->caption = 'New Photo';
        $photo->location = 'New Location';
        $photo->userId = $user->id;
        $savedPhoto = $this->photoRepository->save($photo);
        $this->assertNotNull($savedPhoto->id);
        $this->assertIsInt($savedPhoto->id);
        $this->assertEquals('New Photo', $savedPhoto->caption);
        $this->assertEquals('New Location', $savedPhoto->location);
        $this->assertEquals($user->id, $savedPhoto->userId);
        $foundPhoto = $this->photoRepository->findById($savedPhoto->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals('New Photo', $foundPhoto->caption);
        $this->assertEquals('New Location', $foundPhoto->location);
        $this->assertEquals($user->id, $foundPhoto->userId);
        $this->assertEquals('Test User', $foundPhoto->userName);
    }
    public function testUpdateSuccess(): void
    {
        $photo = $this->createPhoto('Original Caption', 'Original Location');
        $photo->caption = 'Updated Caption';
        $photo->location = 'Updated Location';
        $updatedPhoto = $this->photoRepository->update($photo);
        $this->assertEquals('Updated Caption', $updatedPhoto->caption);
        $this->assertEquals('Updated Location', $updatedPhoto->location);
        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals('Updated Caption', $foundPhoto->caption);
        $this->assertEquals('Updated Location', $foundPhoto->location);
        $this->assertNotNull($foundPhoto->updatedAt);
    }
    public function testFindByIdSuccess(): void
    {
        $photo = $this->createPhoto('Find By ID Test', 'Find Location');
        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals($photo->id, $foundPhoto->id);
        $this->assertEquals('Find By ID Test', $foundPhoto->caption);
        $this->assertEquals('Find Location', $foundPhoto->location);
        $this->assertEquals($photo->userId, $foundPhoto->userId);
        $this->assertEquals('Test User', $foundPhoto->userName);
    }
    public function testFindByIdNotFound(): void
    {
        $foundPhoto = $this->photoRepository->findById(99999);
        $this->assertNull($foundPhoto);
    }
    public function testFindAllSuccess(): void
    {
        $this->createPhoto('First Photo', 'Location 1');
        $this->createPhoto('Second Photo', 'Location 2');
        $this->createPhoto('Third Photo', 'Location 3');
        $photos = $this->photoRepository->findAll();
        $this->assertCount(3, $photos);
        $this->assertEquals('Third Photo', $photos[0]->caption);
        $this->assertEquals('Second Photo', $photos[1]->caption);
        $this->assertEquals('First Photo', $photos[2]->caption);
        foreach ($photos as $photo) {
            $this->assertNotEmpty($photo->userName);
            $this->assertEquals('Test User', $photo->userName);
        }
    }
    public function testFindAllEmpty(): void
    {
        $photos = $this->photoRepository->findAll();
        $this->assertEmpty($photos);
        $this->assertIsArray($photos);
    }
    public function testFindByUserIdSuccess(): void
    {
        $user1 = $this->createUser('User One', 'user1@example.com');
        $user2 = $this->createUser('User Two', 'user2@example.com');
        $this->createPhoto('User1 Photo 1', 'Location 1', $user1);
        $this->createPhoto('User1 Photo 2', 'Location 2', $user1);
        $this->createPhoto('User2 Photo', 'Location 3', $user2);
        $user1Photos = $this->photoRepository->findByUserId($user1->id);
        $this->assertCount(2, $user1Photos);
        $this->assertEquals($user1->id, $user1Photos[0]->userId);
        $this->assertEquals($user1->id, $user1Photos[1]->userId);
        $this->assertEquals('User One', $user1Photos[0]->userName);
        $user2Photos = $this->photoRepository->findByUserId($user2->id);
        $this->assertCount(1, $user2Photos);
        $this->assertEquals($user2->id, $user2Photos[0]->userId);
        $this->assertEquals('User Two', $user2Photos[0]->userName);
    }
    public function testFindByUserIdEmpty(): void
    {
        $user = $this->createUser('Empty User', 'empty@example.com');
        $photos = $this->photoRepository->findByUserId($user->id);
        $this->assertEmpty($photos);
        $this->assertIsArray($photos);
    }
    public function testSoftDeleteSuccess(): void
    {
        $photo = $this->createPhoto('Delete Me', 'Delete Location');
        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNotNull($foundPhoto);
        $this->photoRepository->softDelete($photo->id);
        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNull($foundPhoto);
        $allPhotos = $this->photoRepository->findAll();
        $this->assertEmpty($allPhotos);
        $statement = $this->pdo->prepare("SELECT deleted_at FROM photos WHERE id = ?");
        $statement->execute([$photo->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }
    public function testSoftDeleteNonExistentId(): void
    {
        $this->photoRepository->softDelete(99999);
        $allPhotos = $this->photoRepository->findAll();
        $this->assertEmpty($allPhotos);
    }
    public function testDeleteAllSuccess(): void
    {
        $this->createPhoto('Photo 1', 'Location 1');
        $this->createPhoto('Photo 2', 'Location 2');
        $this->photoRepository->deleteAll();
        $allPhotos = $this->photoRepository->findAll();
        $this->assertEmpty($allPhotos);
        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM photos");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }
    public function testSaveWithEmptyFields(): void
    {
        $user = $this->createUser();
        $photo = new Photo();
        $photo->caption = '';
        $photo->location = '';
        $photo->userId = $user->id;
        $savedPhoto = $this->photoRepository->save($photo);
        $this->assertNotNull($savedPhoto->id);
        $this->assertEquals('', $savedPhoto->caption);
        $this->assertEquals('', $savedPhoto->location);
        $foundPhoto = $this->photoRepository->findById($savedPhoto->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals('', $foundPhoto->caption);
        $this->assertEquals('', $foundPhoto->location);
        $this->assertEquals($user->id, $foundPhoto->userId);
        $this->assertEquals('Test User', $foundPhoto->userName);
    }
}