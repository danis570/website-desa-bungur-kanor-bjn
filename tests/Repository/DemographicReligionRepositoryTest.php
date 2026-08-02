<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicReligion;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicReligionRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class DemographicReligionRepositoryTest extends TestCase
{
    private PDO $pdo;
    private DemographicReligionRepository $religionRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->religionRepository = new DemographicReligionRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->religionRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createReligion(string $religion, int $total): DemographicReligion
    {
        $data = new DemographicReligion();
        $data->religion = $religion;
        $data->total = $total;

        return $this->religionRepository->save($data);
    }

    public function testSaveSuccess(): void
    {
        $data = new DemographicReligion();
        $data->religion = 'Islam';
        $data->total = 4050;

        $saved = $this->religionRepository->save($data);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('Islam', $saved->religion);
        $this->assertEquals(4050, $saved->total);
    }

    public function testUpdateSuccess(): void
    {
        $data = $this->createReligion('Islam', 4050);

        $data->total = 4100;
        $updated = $this->religionRepository->update($data);

        $this->assertEquals(4100, $updated->total);

        $found = $this->religionRepository->findById($data->id);
        $this->assertNotNull($found);
        $this->assertEquals(4100, $found->total);
    }

    public function testFindAllSuccess(): void
    {
        $this->createReligion('Islam', 4050);
        $this->createReligion('Kristen', 35);
        $this->createReligion('Katolik', 10);

        $religions = $this->religionRepository->findAll();

        $this->assertCount(3, $religions);
        $this->assertEquals('Islam', $religions[0]->religion);
        $this->assertEquals(4050, $religions[0]->total);
        $this->assertEquals('Kristen', $religions[1]->religion);
        $this->assertEquals('Katolik', $religions[2]->religion);
    }

    public function testFindAllEmpty(): void
    {
        $religions = $this->religionRepository->findAll();
        $this->assertEmpty($religions);
        $this->assertIsArray($religions);
    }

    public function testFindByIdSuccess(): void
    {
        $data = $this->createReligion('Islam', 4050);

        $found = $this->religionRepository->findById($data->id);

        $this->assertNotNull($found);
        $this->assertEquals('Islam', $found->religion);
        $this->assertEquals(4050, $found->total);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->religionRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createReligion('Islam', 4050);
        $this->createReligion('Kristen', 35);

        $this->religionRepository->deleteAll();

        $religions = $this->religionRepository->findAll();
        $this->assertEmpty($religions);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM demographic_religions");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }
}