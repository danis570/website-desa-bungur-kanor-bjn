<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageOfficial;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class VillageOfficialRepositoryTest extends TestCase
{
    private PDO $pdo;
    private VillageOfficialRepository $officialRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->officialRepository = new VillageOfficialRepository($this->pdo);
        $this->cleanupDatabase();
    }

    protected function tearDown(): void
    {
        $this->cleanupDatabase();
    }

    private function cleanupDatabase(): void
    {
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->officialRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    private function createOfficial(
        string $name = 'Ahmad Fauzi',
        string $position = 'Kepala Desa',
        string $period = '2021-2026',
        bool $isActive = true
    ): VillageOfficial {
        $official = new VillageOfficial();
        $official->name = $name;
        $official->position = $position;
        $official->period = $period;
        $official->isActive = $isActive;
        $official->whatsapp = '081234567890';
        $official->email = 'test@desa.id';
        $official->address = 'Kantor Desa Bungur';

        return $this->officialRepository->save($official);
    }

    public function testSaveSuccess(): void
    {
        $official = new VillageOfficial();
        $official->name = 'Budi Santoso';
        $official->position = 'Sekretaris Desa';
        $official->period = '2021-2026';
        $official->isActive = true;
        $official->whatsapp = '081234567891';
        $official->email = 'sekdes@desa.id';
        $official->address = 'Kantor Desa Bungur';
        $official->photo = 'official_123.jpg';

        $saved = $this->officialRepository->save($official);

        $this->assertNotNull($saved->id);
        $this->assertIsInt($saved->id);
        $this->assertEquals('Budi Santoso', $saved->name);
        $this->assertEquals('Sekretaris Desa', $saved->position);
        $this->assertEquals('2021-2026', $saved->period);
        $this->assertTrue($saved->isActive);
        $this->assertEquals('official_123.jpg', $saved->photo);

        $found = $this->officialRepository->findById($saved->id);
        $this->assertNotNull($found);
        $this->assertEquals('Budi Santoso', $found->name);
    }

    public function testUpdateSuccess(): void
    {
        $official = $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026');

        $official->name = 'Ahmad Fauzi Update';
        $official->position = 'Kepala Desa Update';
        $official->period = '2021-2027';
        $official->isActive = false;
        $official->photo = 'official_update.jpg';

        $updated = $this->officialRepository->update($official);

        $this->assertEquals('Ahmad Fauzi Update', $updated->name);
        $this->assertEquals('Kepala Desa Update', $updated->position);
        $this->assertEquals('2021-2027', $updated->period);
        $this->assertFalse($updated->isActive);
        $this->assertEquals('official_update.jpg', $updated->photo);
        $this->assertNotNull($updated->updatedAt);

        $found = $this->officialRepository->findById($official->id);
        $this->assertNotNull($found);
        $this->assertEquals('Ahmad Fauzi Update', $found->name);
    }

    public function testFindByIdSuccess(): void
    {
        $official = $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026');

        $found = $this->officialRepository->findById($official->id);

        $this->assertNotNull($found);
        $this->assertEquals($official->id, $found->id);
        $this->assertEquals('Ahmad Fauzi', $found->name);
        $this->assertEquals('Kepala Desa', $found->position);
        $this->assertEquals('2021-2026', $found->period);
        $this->assertTrue($found->isActive);
    }

    public function testFindByIdNotFound(): void
    {
        $found = $this->officialRepository->findById(99999);
        $this->assertNull($found);
    }

    public function testFindAllSuccess(): void
    {
        $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026');
        $this->createOfficial('Budi Santoso', 'Sekretaris Desa', '2021-2026');
        $this->createOfficial('Siti Rahayu', 'Kaur Keuangan', '2021-2026');

        $officials = $this->officialRepository->findAll();

        $this->assertCount(3, $officials);
        $this->assertEquals('Ahmad Fauzi', $officials[0]->name);
        $this->assertEquals('Budi Santoso', $officials[1]->name);
        $this->assertEquals('Siti Rahayu', $officials[2]->name);

        foreach ($officials as $official) {
            $this->assertNotNull($official->id);
            $this->assertNotEmpty($official->name);
            $this->assertNotEmpty($official->position);
            $this->assertNotEmpty($official->period);
        }
    }

    public function testFindAllEmpty(): void
    {
        $officials = $this->officialRepository->findAll();
        $this->assertEmpty($officials);
        $this->assertIsArray($officials);
    }

    public function testFindActiveSuccess(): void
    {
        $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026', true);
        $this->createOfficial('Budi Santoso', 'Sekretaris Desa', '2021-2026', true);
        $this->createOfficial('Siti Rahayu', 'Kaur Keuangan', '2021-2026', false);

        $activeOfficials = $this->officialRepository->findActive();

        $this->assertCount(2, $activeOfficials);
        $this->assertEquals('Ahmad Fauzi', $activeOfficials[0]->name);
        $this->assertEquals('Budi Santoso', $activeOfficials[1]->name);

        foreach ($activeOfficials as $official) {
            $this->assertTrue($official->isActive);
        }
    }

    public function testFindActiveEmpty(): void
    {
        $this->createOfficial('Siti Rahayu', 'Kaur Keuangan', '2021-2026', false);

        $activeOfficials = $this->officialRepository->findActive();
        $this->assertEmpty($activeOfficials);
        $this->assertIsArray($activeOfficials);
    }

    public function testSoftDeleteSuccess(): void
    {
        $official = $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026');

        $found = $this->officialRepository->findById($official->id);
        $this->assertNotNull($found);

        $this->officialRepository->softDelete($official->id);

        $found = $this->officialRepository->findById($official->id);
        $this->assertNull($found);

        $allOfficials = $this->officialRepository->findAll();
        $this->assertEmpty($allOfficials);

        $statement = $this->pdo->prepare("SELECT deleted_at FROM village_officials WHERE id = ?");
        $statement->execute([$official->id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertNotNull($row['deleted_at']);
    }

    public function testSoftDeleteNonExistentId(): void
    {
        $this->officialRepository->softDelete(99999);

        $allOfficials = $this->officialRepository->findAll();
        $this->assertEmpty($allOfficials);
    }

    public function testDeleteAllSuccess(): void
    {
        $this->createOfficial('Ahmad Fauzi', 'Kepala Desa', '2021-2026');
        $this->createOfficial('Budi Santoso', 'Sekretaris Desa', '2021-2026');

        $this->officialRepository->deleteAll();

        $allOfficials = $this->officialRepository->findAll();
        $this->assertEmpty($allOfficials);

        $statement = $this->pdo->query("SELECT COUNT(*) as count FROM village_officials");
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        $this->assertEquals(0, (int) $row['count']);
    }

    public function testSaveWithEmptyFields(): void
    {
        $official = new VillageOfficial();
        $official->name = '';
        $official->position = '';
        $official->period = '';
        $official->isActive = true;

        $saved = $this->officialRepository->save($official);

        $this->assertNotNull($saved->id);
        $this->assertEquals('', $saved->name);
        $this->assertEquals('', $saved->position);
        $this->assertEquals('', $saved->period);
        $this->assertTrue($saved->isActive);
    }
}