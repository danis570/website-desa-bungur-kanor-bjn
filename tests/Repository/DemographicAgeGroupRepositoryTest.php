<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicAgeGroup;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicAgeGroupRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class DemographicAgeGroupRepositoryTest extends TestCase
{
    private PDO $pdo;
    private DemographicAgeGroupRepository $ageGroupRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->ageGroupRepository = new DemographicAgeGroupRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->ageGroupRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createAgeGroup(string $ageRange, int $total): DemographicAgeGroup
    {
        $data = new DemographicAgeGroup();
        $data->ageRange = $ageRange;
        $data->total = $total;

        return $this->ageGroupRepository->save($data);
    }

    public function testSaveSuccess(): void
    {
        $data = new DemographicAgeGroup();
        $data->ageRange = '0-5';
        $data->total = 340;

        $saved = $this->ageGroupRepository->save($data);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('0-5', $saved->ageRange);
        $this->assertEquals(340, $saved->total);
    }

    public function testUpdateSuccess(): void
    {
        $data = $this->createAgeGroup('0-5', 340);

        $data->total = 350;
        $updated = $this->ageGroupRepository->update($data);

        $this->assertEquals(350, $updated->total);

        $found = $this->ageGroupRepository->findById($data->id);
        $this->assertNotNull($found);
        $this->assertEquals(350, $found->total);
    }

    public function testFindAllSuccess(): void
    {
        $this->createAgeGroup('0-5', 340);
        $this->createAgeGroup('6-12', 480);
        $this->createAgeGroup('13-17', 420);

        $ageGroups = $this->ageGroupRepository->findAll();

        $this->assertCount(3, $ageGroups);
        $this->assertEquals('0-5', $ageGroups[0]->ageRange);
        $this->assertEquals(340, $ageGroups[0]->total);
        $this->assertEquals('6-12', $ageGroups[1]->ageRange);
        $this->assertEquals('13-17', $ageGroups[2]->ageRange);
    }

    public function testFindAllEmpty(): void
    {
        $ageGroups = $this->ageGroupRepository->findAll();
        $this->assertEmpty($ageGroups);
        $this->assertIsArray($ageGroups);
    }

    public function testFindByIdSuccess(): void
    {
        $data = $this->createAgeGroup('0-5', 340);

        $found = $this->ageGroupRepository->findById($data->id);

        $this->assertNotNull($found);
        $this->assertEquals('0-5', $found->ageRange);
        $this->assertEquals(340, $found->total);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->ageGroupRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createAgeGroup('0-5', 340);
        $this->createAgeGroup('6-12', 480);

        $this->ageGroupRepository->deleteAll();

        $ageGroups = $this->ageGroupRepository->findAll();
        $this->assertEmpty($ageGroups);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM demographic_age_groups");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }
}