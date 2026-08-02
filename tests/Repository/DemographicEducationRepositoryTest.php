<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicEducation;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicEducationRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class DemographicEducationRepositoryTest extends TestCase
{
    private PDO $pdo;
    private DemographicEducationRepository $educationRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->educationRepository = new DemographicEducationRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->educationRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createEducation(string $level, int $total): DemographicEducation
    {
        $data = new DemographicEducation();
        $data->educationLevel = $level;
        $data->total = $total;

        return $this->educationRepository->save($data);
    }

    public function testSaveSuccess(): void
    {
        $data = new DemographicEducation();
        $data->educationLevel = 'SD';
        $data->total = 350;

        $saved = $this->educationRepository->save($data);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('SD', $saved->educationLevel);
        $this->assertEquals(350, $saved->total);
    }

    public function testUpdateSuccess(): void
    {
        $data = $this->createEducation('SD', 350);

        $data->total = 400;
        $updated = $this->educationRepository->update($data);

        $this->assertEquals(400, $updated->total);

        $found = $this->educationRepository->findById($data->id);
        $this->assertNotNull($found);
        $this->assertEquals(400, $found->total);
    }

    public function testFindAllSuccess(): void
    {
        $this->createEducation('SD', 350);
        $this->createEducation('SMP', 280);
        $this->createEducation('SMA', 420);

        $educations = $this->educationRepository->findAll();

        $this->assertCount(3, $educations);
        $this->assertEquals('SD', $educations[0]->educationLevel);
        $this->assertEquals(350, $educations[0]->total);
        $this->assertEquals('SMP', $educations[1]->educationLevel);
        $this->assertEquals('SMA', $educations[2]->educationLevel);
    }

    public function testFindAllEmpty(): void
    {
        $educations = $this->educationRepository->findAll();
        $this->assertEmpty($educations);
        $this->assertIsArray($educations);
    }

    public function testFindByIdSuccess(): void
    {
        $data = $this->createEducation('SD', 350);

        $found = $this->educationRepository->findById($data->id);

        $this->assertNotNull($found);
        $this->assertEquals('SD', $found->educationLevel);
        $this->assertEquals(350, $found->total);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->educationRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createEducation('SD', 350);
        $this->createEducation('SMP', 280);

        $this->educationRepository->deleteAll();

        $educations = $this->educationRepository->findAll();
        $this->assertEmpty($educations);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM demographic_educations");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }
}