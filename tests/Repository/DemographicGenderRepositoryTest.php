<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicGender;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicGenderRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class DemographicGenderRepositoryTest extends TestCase
{
    private PDO $pdo;
    private DemographicGenderRepository $genderRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->genderRepository = new DemographicGenderRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->genderRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createGender(string $gender, int $total): DemographicGender
    {
        $data = new DemographicGender();
        $data->gender = $gender;
        $data->total = $total;

        return $this->genderRepository->save($data);
    }

    public function testSaveSuccess(): void
    {
        $data = new DemographicGender();
        $data->gender = 'Laki-laki';
        $data->total = 125;

        $saved = $this->genderRepository->save($data);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('Laki-laki', $saved->gender);
        $this->assertEquals(125, $saved->total);

        $found = $this->genderRepository->findByGender('Laki-laki');
        $this->assertNotNull($found);
        $this->assertEquals('Laki-laki', $found->gender);
        $this->assertEquals(125, $found->total);
    }

    public function testSaveUpdateExisting(): void
    {
        // Create first
        $this->createGender('Laki-laki', 125);

        // Update with same gender
        $data = new DemographicGender();
        $data->gender = 'Laki-laki';
        $data->total = 150;

        $updated = $this->genderRepository->save($data);

        $this->assertNotNull($updated->id);
        $this->assertEquals('Laki-laki', $updated->gender);
        $this->assertEquals(150, $updated->total);

        $found = $this->genderRepository->findByGender('Laki-laki');
        $this->assertNotNull($found);
        $this->assertEquals(150, $found->total);
    }

    public function testUpdateSuccess(): void
    {
        $data = $this->createGender('Laki-laki', 125);

        $data->total = 200;
        $updated = $this->genderRepository->update($data);

        $this->assertEquals(200, $updated->total);

        $found = $this->genderRepository->findByGender('Laki-laki');
        $this->assertNotNull($found);
        $this->assertEquals(200, $found->total);
    }

    public function testFindAllSuccess(): void
    {
        $this->createGender('Laki-laki', 125);
        $this->createGender('Perempuan', 135);

        $genders = $this->genderRepository->findAll();

        $this->assertCount(2, $genders);
        $this->assertEquals('Laki-laki', $genders[0]->gender);
        $this->assertEquals(125, $genders[0]->total);
        $this->assertEquals('Perempuan', $genders[1]->gender);
        $this->assertEquals(135, $genders[1]->total);
    }

    public function testFindAllEmpty(): void
    {
        $genders = $this->genderRepository->findAll();
        $this->assertEmpty($genders);
        $this->assertIsArray($genders);
    }

    public function testFindByGenderSuccess(): void
    {
        $this->createGender('Laki-laki', 125);

        $found = $this->genderRepository->findByGender('Laki-laki');

        $this->assertNotNull($found);
        $this->assertEquals('Laki-laki', $found->gender);
        $this->assertEquals(125, $found->total);
    }

    public function testFindByGenderNotFound(): void
    {
        $found = $this->genderRepository->findByGender('Tidak Ada');
        $this->assertNull($found);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createGender('Laki-laki', 125);
        $this->createGender('Perempuan', 135);

        $this->genderRepository->deleteAll();

        $genders = $this->genderRepository->findAll();
        $this->assertEmpty($genders);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM demographic_genders");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }
}