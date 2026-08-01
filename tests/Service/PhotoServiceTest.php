<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\Photo;
use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\CreatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UpdatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\PhotoService;
use PDO;
use PHPUnit\Framework\TestCase;

class PhotoServiceTest extends TestCase
{
    private PDO $pdo;
    private PhotoService $photoService;
    private PhotoRepository $photoRepository;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->photoRepository = new PhotoRepository($this->pdo);
        $this->userRepository = new UserRepository($this->pdo);
        $this->photoService = new PhotoService($this->photoRepository, $this->userRepository);

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

    private function createUser(
        string $name = 'Test User',
        ?string $email = null
    ): User {
        $user = new User();
        $user->name = $name;
        $user->email = $email ?? 'test' . uniqid() . '@example.com';
        $user->password = password_hash('password123', PASSWORD_DEFAULT);
        $user->role = 'user';

        return $this->userRepository->save($user);
    }

    private function createPhoto(
        string $caption = 'Test Photo',
        string $location = 'Test Location',
        ?User $user = null
    ): Photo {
        if ($user === null) {
            $user = $this->createUser();
        }

        $photo = new Photo();
        $photo->caption = $caption;
        $photo->location = $location;
        $photo->userId = $user->id;

        return $this->photoRepository->save($photo);
    }

    public function testCreateSuccess(): void
    {
        $user = $this->createUser();

        $request = new CreatePhotoRequest(
            'New Photo',
            'New Location',
            $user->id
        );

        $response = $this->photoService->create($request);

        $this->assertNotNull($response->photo->id);
        $this->assertIsInt($response->photo->id);
        $this->assertEquals('New Photo', $response->photo->caption);
        $this->assertEquals('New Location', $response->photo->location);
        $this->assertEquals($user->id, $response->photo->userId);

        $foundPhoto = $this->photoRepository->findById($response->photo->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals('New Photo', $foundPhoto->caption);
        $this->assertEquals('New Location', $foundPhoto->location);
    }

    public function testCreateWithEmptyCaption(): void
    {
        $user = $this->createUser();

        $request = new CreatePhotoRequest(
            '',
            'Location',
            $user->id
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Caption tidak boleh kosong');

        $this->photoService->create($request);
    }

    public function testCreateWithInvalidUserId(): void
    {
        $request = new CreatePhotoRequest(
            'New Photo',
            'Location',
            0
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('User ID tidak valid.');

        $this->photoService->create($request);
    }

    public function testCreateWithNonExistentUser(): void
    {
        $request = new CreatePhotoRequest(
            'New Photo',
            'Location',
            99999
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('User tidak ditemukan');

        $this->photoService->create($request);
    }

    public function testUpdateSuccess(): void
    {
        $photo = $this->createPhoto('Original Caption', 'Original Location');

        $request = new UpdatePhotoRequest(
            $photo->id,
            'Updated Caption',
            'Updated Location'
        );

        $response = $this->photoService->update($request);

        $this->assertEquals($photo->id, $response->photo->id);
        $this->assertEquals('Updated Caption', $response->photo->caption);
        $this->assertEquals('Updated Location', $response->photo->location);

        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNotNull($foundPhoto);
        $this->assertEquals('Updated Caption', $foundPhoto->caption);
        $this->assertEquals('Updated Location', $foundPhoto->location);
        $this->assertNotNull($foundPhoto->updatedAt);
    }

    public function testUpdateWithInvalidId(): void
    {
        $request = new UpdatePhotoRequest(
            0,
            'Updated Caption',
            'Updated Location'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('ID tidak valid.');

        $this->photoService->update($request);
    }

    public function testUpdateWithEmptyCaption(): void
    {
        $photo = $this->createPhoto('Original Caption', 'Original Location');

        $request = new UpdatePhotoRequest(
            $photo->id,
            '',
            'Updated Location'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Caption tidak boleh kosong');

        $this->photoService->update($request);
    }

    public function testUpdateNonExistentPhoto(): void
    {
        $request = new UpdatePhotoRequest(
            99999,
            'Updated Caption',
            'Updated Location'
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Photo tidak ditemukan');

        $this->photoService->update($request);
    }

    public function testFindByIdSuccess(): void
    {
        $photo = $this->createPhoto('Find By ID Test', 'Find Location');

        $response = $this->photoService->findById($photo->id);

        $this->assertNotNull($response->photo);
        $this->assertEquals($photo->id, $response->photo->id);
        $this->assertEquals('Find By ID Test', $response->photo->caption);
        $this->assertEquals('Find Location', $response->photo->location);
        $this->assertEquals($photo->userId, $response->photo->userId);
    }

    public function testFindByIdNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Photo tidak ditemukan');

        $this->photoService->findById(99999);
    }

    public function testFindAllSuccess(): void
    {
        $this->createPhoto('First Photo', 'Location 1');
        $this->createPhoto('Second Photo', 'Location 2');
        $this->createPhoto('Third Photo', 'Location 3');

        $photos = $this->photoService->findAll();

        $this->assertCount(3, $photos);
        $this->assertEquals('Third Photo', $photos[0]->caption);
        $this->assertEquals('Second Photo', $photos[1]->caption);
        $this->assertEquals('First Photo', $photos[2]->caption);

        foreach ($photos as $photo) {
            $this->assertNotEmpty($photo->userName);
        }
    }

    public function testFindAllEmpty(): void
    {
        $photos = $this->photoService->findAll();
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

        $user1Photos = $this->photoService->findByUserId($user1->id);

        $this->assertCount(2, $user1Photos);
        $this->assertEquals($user1->id, $user1Photos[0]->userId);
        $this->assertEquals($user1->id, $user1Photos[1]->userId);
        $this->assertEquals('User One', $user1Photos[0]->userName);

        $user2Photos = $this->photoService->findByUserId($user2->id);
        $this->assertCount(1, $user2Photos);
        $this->assertEquals($user2->id, $user2Photos[0]->userId);
        $this->assertEquals('User Two', $user2Photos[0]->userName);
    }

    public function testFindByUserIdEmpty(): void
    {
        $user = $this->createUser('Empty User', 'empty@example.com');

        $photos = $this->photoService->findByUserId($user->id);
        $this->assertEmpty($photos);
        $this->assertIsArray($photos);
    }

    public function testFindByUserIdWithNonExistentUser(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('User tidak ditemukan');

        $this->photoService->findByUserId(99999);
    }

    public function testDeleteSuccess(): void
    {
        $photo = $this->createPhoto('Delete Me', 'Delete Location');

        $foundPhoto = $this->photoRepository->findById($photo->id);
        $this->assertNotNull($foundPhoto);

        $this->photoService->delete($photo->id);

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

    public function testDeleteNonExistentPhoto(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Photo tidak ditemukan');

        $this->photoService->delete(99999);
    }
}