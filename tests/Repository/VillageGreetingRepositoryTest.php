<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageGreeting;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class VillageGreetingRepositoryTest extends TestCase
{
    private PDO $pdo;
    private VillageGreetingRepository $greetingRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->greetingRepository = new VillageGreetingRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->greetingRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createGreeting(
        string $name = 'Ahmad Fauzi',
        string $content = 'Sambutan Kepala Desa'
    ): VillageGreeting {
        $greeting = new VillageGreeting();
        $greeting->name = $name;
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = $content;
        $greeting->closing = 'Wassalamualaikum';
        $greeting->image = 'kades_123.jpg';
        $greeting->signatureImage = 'ttd_123.jpg';

        return $this->greetingRepository->save($greeting);
    }

    public function testSaveSuccess(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = 'Budi Santoso';
        $greeting->opening = 'Assalamualaikum';
        $greeting->content = 'Sambutan Kepala Desa Bungur';
        $greeting->closing = 'Wassalamualaikum';
        $greeting->image = 'kades_456.jpg';
        $greeting->signatureImage = 'ttd_456.jpg';

        $saved = $this->greetingRepository->save($greeting);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('Budi Santoso', $saved->name);
        $this->assertEquals('Assalamualaikum', $saved->opening);
        $this->assertEquals('Sambutan Kepala Desa Bungur', $saved->content);
        $this->assertEquals('Wassalamualaikum', $saved->closing);
        $this->assertEquals('kades_456.jpg', $saved->image);
        $this->assertEquals('ttd_456.jpg', $saved->signatureImage);

        $found = $this->greetingRepository->findById($saved->id);
        $this->assertNotNull($found);
        $this->assertEquals('Budi Santoso', $found->name);
        $this->assertEquals('Sambutan Kepala Desa Bungur', $found->content);
    }

    public function testUpdateSuccess(): void
    {
        $greeting = $this->createGreeting('Ahmad Fauzi', 'Sambutan Awal');

        $greeting->name = 'Ahmad Fauzi Update';
        $greeting->opening = 'Assalamualaikum Update';
        $greeting->content = 'Sambutan Update';
        $greeting->closing = 'Wassalamualaikum Update';
        $greeting->image = 'kades_update.jpg';
        $greeting->signatureImage = 'ttd_update.jpg';

        $updated = $this->greetingRepository->update($greeting);

        $this->assertEquals('Ahmad Fauzi Update', $updated->name);
        $this->assertEquals('Assalamualaikum Update', $updated->opening);
        $this->assertEquals('Sambutan Update', $updated->content);
        $this->assertEquals('Wassalamualaikum Update', $updated->closing);
        $this->assertEquals('kades_update.jpg', $updated->image);
        $this->assertEquals('ttd_update.jpg', $updated->signatureImage);
        $this->assertNotNull($updated->updatedAt);

        $found = $this->greetingRepository->findById($greeting->id);
        $this->assertNotNull($found);
        $this->assertEquals('Ahmad Fauzi Update', $found->name);
        $this->assertEquals('Sambutan Update', $found->content);
    }

    public function testFindByIdSuccess(): void
    {
        $greeting = $this->createGreeting('Ahmad Fauzi', 'Sambutan Kepala Desa');

        $found = $this->greetingRepository->findById($greeting->id);

        $this->assertNotNull($found);
        $this->assertEquals($greeting->id, $found->id);
        $this->assertEquals('Ahmad Fauzi', $found->name);
        $this->assertEquals('Sambutan Kepala Desa', $found->content);
        $this->assertEquals('kades_123.jpg', $found->image);
        $this->assertEquals('ttd_123.jpg', $found->signatureImage);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->greetingRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testFindFirstSuccess(): void
    {
        $this->createGreeting('First', 'Sambutan Pertama');
        $this->createGreeting('Second', 'Sambutan Kedua');

        $first = $this->greetingRepository->findFirst();

        $this->assertNotNull($first);
        $this->assertEquals('First', $first->name);
    }

    public function testFindFirstEmpty(): void
    {
        $first = $this->greetingRepository->findFirst();
        $this->assertNull($first);
    }

    public function testFindAllSuccess(): void
{
    // Insert dengan jeda agar created_at berbeda
    sleep(1);
    $this->createGreeting('Greeting 1', 'Sambutan 1');
    sleep(1);
    $this->createGreeting('Greeting 2', 'Sambutan 2');
    sleep(1);
    $this->createGreeting('Greeting 3', 'Sambutan 3');

    $greetings = $this->greetingRepository->findAll();

    $this->assertCount(3, $greetings);
    // Karena ORDER BY created_at DESC, data terakhir jadi pertama
    $this->assertEquals('Greeting 3', $greetings[0]->name);
    $this->assertEquals('Greeting 2', $greetings[1]->name);
    $this->assertEquals('Greeting 1', $greetings[2]->name);

    foreach ($greetings as $greeting) {
        $this->assertNotNull($greeting->id);
        $this->assertNotEmpty($greeting->name);
        $this->assertNotEmpty($greeting->content);
    }
}

    public function testFindAllEmpty(): void
    {
        $greetings = $this->greetingRepository->findAll();
        $this->assertEmpty($greetings);
        $this->assertIsArray($greetings);
    }

    public function testSoftDeleteSuccess(): void
    {
        $greeting = $this->createGreeting('Ahmad Fauzi', 'Sambutan');

        $found = $this->greetingRepository->findById($greeting->id);
        $this->assertNotNull($found);

        $this->greetingRepository->softDelete($greeting->id);

        $found = $this->greetingRepository->findById($greeting->id);
        $this->assertNull($found);

        $allGreetings = $this->greetingRepository->findAll();
        $this->assertEmpty($allGreetings);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM village_greetings WHERE id = ?");
        $statement->execute([$greeting->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->greetingRepository->softDelete(99999);

        $allGreetings = $this->greetingRepository->findAll();
        $this->assertEmpty($allGreetings);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createGreeting('Greeting 1', 'Sambutan 1');
        $this->createGreeting('Greeting 2', 'Sambutan 2');

        $this->greetingRepository->deleteAll();

        $allGreetings = $this->greetingRepository->findAll();
        $this->assertEmpty($allGreetings);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM village_greetings");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $greeting = new VillageGreeting();
        $greeting->name = '';
        $greeting->opening = '';
        $greeting->content = '';
        $greeting->closing = '';
        $greeting->image = null;
        $greeting->signatureImage = null;

        $saved = $this->greetingRepository->save($greeting);

        $this->assertNotNull($saved->id);
        $this->assertEquals('', $saved->name);
        $this->assertEquals('', $saved->opening);
        $this->assertEquals('', $saved->content);
        $this->assertEquals('', $saved->closing);
        $this->assertNull($saved->image);
        $this->assertNull($saved->signatureImage);
    }
}
