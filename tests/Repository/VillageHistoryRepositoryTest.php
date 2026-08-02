<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageHistory;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class VillageHistoryRepositoryTest extends TestCase
{
    private PDO $pdo;
    private VillageHistoryRepository $historyRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->historyRepository = new VillageHistoryRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->historyRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createHistory(
        int $year = 1923,
        string $title = 'Awal Berdirinya Desa',
        string $description = 'Desa Bungur mulai terbentuk...'
    ): VillageHistory {
        $history = new VillageHistory();
        $history->year = $year;
        $history->title = $title;
        $history->description = $description;
        $history->image = 'history_123.jpg';

        return $this->historyRepository->save($history);
    }

    public function testSaveSuccess(): void
    {
        $history = new VillageHistory();
        $history->year = 1945;
        $history->title = 'Kemerdekaan Indonesia';
        $history->description = 'Proklamasi Kemerdekaan Indonesia';
        $history->image = 'history_1945.jpg';

        $saved = $this->historyRepository->save($history);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals(1945, $saved->year);
        $this->assertEquals('Kemerdekaan Indonesia', $saved->title);
        $this->assertEquals('Proklamasi Kemerdekaan Indonesia', $saved->description);
        $this->assertEquals('history_1945.jpg', $saved->image);

        $found = $this->historyRepository->findById($saved->id);
        $this->assertNotNull($found);
        $this->assertEquals(1945, $found->year);
        $this->assertEquals('Kemerdekaan Indonesia', $found->title);
    }

    public function testUpdateSuccess(): void
    {
        $history = $this->createHistory(1923, 'Awal Berdirinya Desa', 'Desa Bungur mulai terbentuk...');

        $history->year = 1925;
        $history->title = 'Awal Berdirinya Desa Update';
        $history->description = 'Deskripsi update';
        $history->image = 'history_update.jpg';

        $updated = $this->historyRepository->update($history);

        $this->assertEquals(1925, $updated->year);
        $this->assertEquals('Awal Berdirinya Desa Update', $updated->title);
        $this->assertEquals('Deskripsi update', $updated->description);
        $this->assertEquals('history_update.jpg', $updated->image);
        $this->assertNotNull($updated->updatedAt);

        $found = $this->historyRepository->findById($history->id);
        $this->assertNotNull($found);
        $this->assertEquals(1925, $found->year);
        $this->assertEquals('Awal Berdirinya Desa Update', $found->title);
    }

    public function testFindByIdSuccess(): void
    {
        $history = $this->createHistory(1923, 'Awal Berdirinya Desa', 'Desa Bungur mulai terbentuk...');

        $found = $this->historyRepository->findById($history->id);

        $this->assertNotNull($found);
        $this->assertEquals($history->id, $found->id);
        $this->assertEquals(1923, $found->year);
        $this->assertEquals('Awal Berdirinya Desa', $found->title);
        $this->assertEquals('Desa Bungur mulai terbentuk...', $found->description);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->historyRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testFindAllSuccess(): void
    {
        $this->createHistory(1923, 'Awal Berdirinya Desa', 'Deskripsi 1');
        $this->createHistory(1945, 'Kemerdekaan', 'Deskripsi 2');
        $this->createHistory(2010, 'Modernisasi', 'Deskripsi 3');

        $histories = $this->historyRepository->findAll();

        $this->assertCount(3, $histories);
        $this->assertEquals(2010, $histories[0]->year);
        $this->assertEquals(1945, $histories[1]->year);
        $this->assertEquals(1923, $histories[2]->year);

        foreach ($histories as $history) {
            $this->assertNotNull($history->id);
            $this->assertNotEmpty($history->title);
            $this->assertNotEmpty($history->description);
        }
    }

    public function testFindAllEmpty(): void
    {
        $histories = $this->historyRepository->findAll();
        $this->assertEmpty($histories);
        $this->assertIsArray($histories);
    }

    public function testSoftDeleteSuccess(): void
    {
        $history = $this->createHistory(1923, 'Awal Berdirinya Desa', 'Deskripsi');

        $found = $this->historyRepository->findById($history->id);
        $this->assertNotNull($found);

        $this->historyRepository->softDelete($history->id);

        $found = $this->historyRepository->findById($history->id);
        $this->assertNull($found);

        $allHistories = $this->historyRepository->findAll();
        $this->assertEmpty($allHistories);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM village_histories WHERE id = ?");
        $statement->execute([$history->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->historyRepository->softDelete(99999);

        $allHistories = $this->historyRepository->findAll();
        $this->assertEmpty($allHistories);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createHistory(1923, 'Awal Berdirinya Desa', 'Deskripsi 1');
        $this->createHistory(1945, 'Kemerdekaan', 'Deskripsi 2');

        $this->historyRepository->deleteAll();

        $allHistories = $this->historyRepository->findAll();
        $this->assertEmpty($allHistories);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM village_histories");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $history = new VillageHistory();
        $history->year = 0;
        $history->title = '';
        $history->description = '';
        $history->image = null;

        $saved = $this->historyRepository->save($history);

        $this->assertNotNull($saved->id);
        $this->assertEquals(0, $saved->year);
        $this->assertEquals('', $saved->title);
        $this->assertEquals('', $saved->description);
        $this->assertNull($saved->image);
    }
}