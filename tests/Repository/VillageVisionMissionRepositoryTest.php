<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageVisionMission;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class VillageVisionMissionRepositoryTest extends TestCase
{
    private PDO $pdo;
    private VillageVisionMissionRepository $visionMissionRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->visionMissionRepository = new VillageVisionMissionRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->visionMissionRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createVisionMission(
        string $type = 'vision',
        string $description = 'Visi Desa Bungur',
        int $sortOrder = 1
    ): VillageVisionMission {
        $item = new VillageVisionMission();
        $item->type = $type;
        $item->description = $description;
        $item->sortOrder = $sortOrder;

        return $this->visionMissionRepository->save($item);
    }

    public function testSaveSuccess(): void
    {
        $item = new VillageVisionMission();
        $item->type = 'vision';
        $item->description = 'Visi Desa Bungur Maju';
        $item->sortOrder = 1;

        $saved = $this->visionMissionRepository->save($item);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('vision', $saved->type);
        $this->assertEquals('Visi Desa Bungur Maju', $saved->description);
        $this->assertEquals(1, $saved->sortOrder);

        $found = $this->visionMissionRepository->findById($saved->id);
        $this->assertNotNull($found);
        $this->assertEquals('vision', $found->type);
        $this->assertEquals('Visi Desa Bungur Maju', $found->description);
    }

    public function testUpdateSuccess(): void
    {
        $item = $this->createVisionMission('vision', 'Visi Desa Bungur', 1);

        $item->type = 'mission';
        $item->description = 'Misi Desa Bungur Update';
        $item->sortOrder = 2;

        $updated = $this->visionMissionRepository->update($item);

        $this->assertEquals('mission', $updated->type);
        $this->assertEquals('Misi Desa Bungur Update', $updated->description);
        $this->assertEquals(2, $updated->sortOrder);
        $this->assertNotNull($updated->updatedAt);

        $found = $this->visionMissionRepository->findById($item->id);
        $this->assertNotNull($found);
        $this->assertEquals('mission', $found->type);
        $this->assertEquals('Misi Desa Bungur Update', $found->description);
    }

    public function testFindByIdSuccess(): void
    {
        $item = $this->createVisionMission('vision', 'Visi Desa Bungur', 1);

        $found = $this->visionMissionRepository->findById($item->id);

        $this->assertNotNull($found);
        $this->assertEquals($item->id, $found->id);
        $this->assertEquals('vision', $found->type);
        $this->assertEquals('Visi Desa Bungur', $found->description);
        $this->assertEquals(1, $found->sortOrder);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->visionMissionRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testFindAllSuccess(): void
    {
        $this->createVisionMission('vision', 'Visi 1', 1);
        $this->createVisionMission('vision', 'Visi 2', 2);
        $this->createVisionMission('mission', 'Misi 1', 1);
        $this->createVisionMission('mission', 'Misi 2', 2);

        $items = $this->visionMissionRepository->findAll();

        $this->assertCount(4, $items);
        $this->assertEquals('vision', $items[0]->type);
        $this->assertEquals('vision', $items[1]->type);
        $this->assertEquals('mission', $items[2]->type);
        $this->assertEquals('mission', $items[3]->type);

        foreach ($items as $item) {
            $this->assertNotNull($item->id);
            $this->assertNotEmpty($item->type);
            $this->assertNotEmpty($item->description);
        }
    }

    public function testFindAllEmpty(): void
    {
        $items = $this->visionMissionRepository->findAll();
        $this->assertEmpty($items);
        $this->assertIsArray($items);
    }

    public function testFindByTypeSuccess(): void
    {
        $this->createVisionMission('vision', 'Visi 1', 1);
        $this->createVisionMission('vision', 'Visi 2', 2);
        $this->createVisionMission('mission', 'Misi 1', 1);
        $this->createVisionMission('mission', 'Misi 2', 2);

        $visions = $this->visionMissionRepository->findByType('vision');
        $missions = $this->visionMissionRepository->findByType('mission');

        $this->assertCount(2, $visions);
        $this->assertCount(2, $missions);

        foreach ($visions as $vision) {
            $this->assertEquals('vision', $vision->type);
        }

        foreach ($missions as $mission) {
            $this->assertEquals('mission', $mission->type);
        }
    }

    public function testFindByTypeEmpty(): void
    {
        $visions = $this->visionMissionRepository->findByType('vision');
        $missions = $this->visionMissionRepository->findByType('mission');

        $this->assertEmpty($visions);
        $this->assertEmpty($missions);
        $this->assertIsArray($visions);
        $this->assertIsArray($missions);
    }

    public function testSoftDeleteSuccess(): void
    {
        $item = $this->createVisionMission('vision', 'Visi Desa Bungur', 1);

        $found = $this->visionMissionRepository->findById($item->id);
        $this->assertNotNull($found);

        $this->visionMissionRepository->softDelete($item->id);

        $found = $this->visionMissionRepository->findById($item->id);
        $this->assertNull($found);

        $allItems = $this->visionMissionRepository->findAll();
        $this->assertEmpty($allItems);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM village_visions_missions WHERE id = ?");
        $statement->execute([$item->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->visionMissionRepository->softDelete(99999);

        $allItems = $this->visionMissionRepository->findAll();
        $this->assertEmpty($allItems);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createVisionMission('vision', 'Visi 1', 1);
        $this->createVisionMission('mission', 'Misi 1', 1);

        $this->visionMissionRepository->deleteAll();

        $allItems = $this->visionMissionRepository->findAll();
        $this->assertEmpty($allItems);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM village_visions_missions");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $item = new VillageVisionMission();
        $item->type = '';
        $item->description = '';
        $item->sortOrder = 0;

        $saved = $this->visionMissionRepository->save($item);

        $this->assertNotNull($saved->id);
        $this->assertEquals('', $saved->type);
        $this->assertEquals('', $saved->description);
        $this->assertEquals(0, $saved->sortOrder);
    }
}
