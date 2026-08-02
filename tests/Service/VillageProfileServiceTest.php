<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageHistory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageOfficial;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageVisionMission;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\VillageProfileService;
use PDO;
use PHPUnit\Framework\TestCase;

class VillageProfileServiceTest extends TestCase
{
    private PDO $pdo;
    private VillageProfileService $service;
    private VillageOfficialRepository $officialRepository;
    private VillageHistoryRepository $historyRepository;
    private VillageVisionMissionRepository $visionMissionRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->officialRepository = new VillageOfficialRepository($this->pdo);
        $this->historyRepository = new VillageHistoryRepository($this->pdo);
        $this->visionMissionRepository = new VillageVisionMissionRepository($this->pdo);

        $this->service = new VillageProfileService(
            $this->officialRepository,
            $this->historyRepository,
            $this->visionMissionRepository
        );

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
        $this->historyRepository->deleteAll();
        $this->visionMissionRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    // ==========================================================
    // OFFICIAL TESTS
    // ==========================================================

    public function testCreateOfficialSuccess(): void
    {
        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = 'Kepala Desa';
        $official->period = '2021-2026';
        $official->isActive = true;

        $created = $this->service->createOfficial($official);

        $this->assertNotNull($created->id);
        $this->assertEquals('Ahmad Fauzi', $created->name);
        $this->assertEquals('Kepala Desa', $created->position);
        $this->assertEquals('2021-2026', $created->period);
        $this->assertTrue($created->isActive);
    }

    public function testCreateOfficialWithEmptyName(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Nama perangkat desa tidak boleh kosong');

        $official = new VillageOfficial();
        $official->name = '';
        $official->position = 'Kepala Desa';
        $official->period = '2021-2026';

        $this->service->createOfficial($official);
    }

    public function testCreateOfficialWithEmptyPosition(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Jabatan tidak boleh kosong');

        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = '';
        $official->period = '2021-2026';

        $this->service->createOfficial($official);
    }

    public function testCreateOfficialWithEmptyPeriod(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Periode tidak boleh kosong');

        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = 'Kepala Desa';
        $official->period = '';

        $this->service->createOfficial($official);
    }

    public function testUpdateOfficialSuccess(): void
    {
        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = 'Kepala Desa';
        $official->period = '2021-2026';
        $created = $this->service->createOfficial($official);

        $created->name = 'Ahmad Fauzi Update';
        $created->position = 'Kepala Desa Update';
        $created->period = '2021-2027';
        $created->isActive = false;

        $updated = $this->service->updateOfficial($created);

        $this->assertEquals('Ahmad Fauzi Update', $updated->name);
        $this->assertEquals('Kepala Desa Update', $updated->position);
        $this->assertEquals('2021-2027', $updated->period);
        $this->assertFalse($updated->isActive);
    }

    public function testUpdateOfficialNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Perangkat desa tidak ditemukan');

        $official = new VillageOfficial();
        $official->id = 99999;
        $official->name = 'Test';
        $official->position = 'Test';
        $official->period = 'Test';

        $this->service->updateOfficial($official);
    }


    public function testGetOfficialByIdSuccess(): void
    {
        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = 'Kepala Desa';
        $official->period = '2021-2026';
        $created = $this->service->createOfficial($official);

        $found = $this->service->getOfficialById($created->id);

        $this->assertNotNull($found);
        $this->assertEquals($created->id, $found->id);
        $this->assertEquals('Ahmad Fauzi', $found->name);
    }

    public function testGetOfficialByIdNotFound(): void
    {
        $found = $this->service->getOfficialById(99999);
        $this->assertNull($found);
    }

    public function testGetAllOfficialsSuccess(): void
    {
        $official1 = new VillageOfficial();
        $official1->name = 'Ahmad Fauzi';
        $official1->position = 'Kepala Desa';
        $official1->period = '2021-2026';
        $this->service->createOfficial($official1);

        $official2 = new VillageOfficial();
        $official2->name = 'Budi Santoso';
        $official2->position = 'Sekretaris Desa';
        $official2->period = '2021-2026';
        $this->service->createOfficial($official2);

        $officials = $this->service->getAllOfficials();

        $this->assertCount(2, $officials);
        $this->assertEquals('Ahmad Fauzi', $officials[0]->name);
        $this->assertEquals('Budi Santoso', $officials[1]->name);
    }

    public function testGetActiveOfficialsSuccess(): void
    {
        $official1 = new VillageOfficial();
        $official1->name = 'Ahmad Fauzi';
        $official1->position = 'Kepala Desa';
        $official1->period = '2021-2026';
        $official1->isActive = true;
        $this->service->createOfficial($official1);

        $official2 = new VillageOfficial();
        $official2->name = 'Budi Santoso';
        $official2->position = 'Sekretaris Desa';
        $official2->period = '2021-2026';
        $official2->isActive = false;
        $this->service->createOfficial($official2);

        $activeOfficials = $this->service->getActiveOfficials();

        $this->assertCount(1, $activeOfficials);
        $this->assertEquals('Ahmad Fauzi', $activeOfficials[0]->name);
        $this->assertTrue($activeOfficials[0]->isActive);
    }

    public function testDeleteOfficialSuccess(): void
    {
        $official = new VillageOfficial();
        $official->name = 'Ahmad Fauzi';
        $official->position = 'Kepala Desa';
        $official->period = '2021-2026';
        $created = $this->service->createOfficial($official);

        $this->service->deleteOfficial($created->id);

        $found = $this->service->getOfficialById($created->id);
        $this->assertNull($found);
    }

public function testDeleteOfficialNotFound(): void
{
    $this->expectException(ValidationException::class);
    $this->expectExceptionMessage('Perangkat desa tidak ditemukan');

    $this->service->deleteOfficial(99999);
}

    // ==========================================================
    // HISTORY TESTS
    // ==========================================================

    public function testCreateHistorySuccess(): void
    {
        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Awal Berdirinya Desa';
        $history->description = 'Desa Bungur mulai terbentuk...';

        $created = $this->service->createHistory($history);

        $this->assertNotNull($created->id);
        $this->assertEquals(1923, $created->year);
        $this->assertEquals('Awal Berdirinya Desa', $created->title);
        $this->assertEquals('Desa Bungur mulai terbentuk...', $created->description);
    }

    public function testCreateHistoryWithInvalidYear(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Tahun tidak valid');

        $history = new VillageHistory();
        $history->year = 0;
        $history->title = 'Test';
        $history->description = 'Test';

        $this->service->createHistory($history);
    }

    public function testCreateHistoryWithEmptyTitle(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Judul sejarah tidak boleh kosong');

        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = '';
        $history->description = 'Test';

        $this->service->createHistory($history);
    }

    public function testCreateHistoryWithEmptyDescription(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Deskripsi sejarah tidak boleh kosong');

        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Test';
        $history->description = '';

        $this->service->createHistory($history);
    }

    public function testUpdateHistorySuccess(): void
    {
        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Awal Berdirinya Desa';
        $history->description = 'Deskripsi awal';
        $created = $this->service->createHistory($history);

        $created->year = 1925;
        $created->title = 'Update Title';
        $created->description = 'Update Description';

        $updated = $this->service->updateHistory($created);

        $this->assertEquals(1925, $updated->year);
        $this->assertEquals('Update Title', $updated->title);
        $this->assertEquals('Update Description', $updated->description);
    }

    public function testUpdateHistoryNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Sejarah desa tidak ditemukan');

        $history = new VillageHistory();
        $history->id = 99999;
        $history->year = 1923;
        $history->title = 'Test';
        $history->description = 'Test';

        $this->service->updateHistory($history);
    }

    public function testGetHistoryByIdSuccess(): void
    {
        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Awal Berdirinya Desa';
        $history->description = 'Deskripsi';
        $created = $this->service->createHistory($history);

        $found = $this->service->getHistoryById($created->id);

        $this->assertNotNull($found);
        $this->assertEquals($created->id, $found->id);
        $this->assertEquals(1923, $found->year);
    }

    public function testGetAllHistoriesSuccess(): void
    {
        $history1 = new VillageHistory();
        $history1->year = 1923;
        $history1->title = 'Awal Berdirinya Desa';
        $history1->description = 'Deskripsi 1';
        $this->service->createHistory($history1);

        $history2 = new VillageHistory();
        $history2->year = 1945;
        $history2->title = 'Kemerdekaan';
        $history2->description = 'Deskripsi 2';
        $this->service->createHistory($history2);

        $histories = $this->service->getAllHistories();

        $this->assertCount(2, $histories);
        $this->assertEquals(1945, $histories[0]->year);
        $this->assertEquals(1923, $histories[1]->year);
    }

    public function testDeleteHistorySuccess(): void
    {
        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Awal Berdirinya Desa';
        $history->description = 'Deskripsi';
        $created = $this->service->createHistory($history);

        $this->service->deleteHistory($created->id);

        $found = $this->service->getHistoryById($created->id);
        $this->assertNull($found);
    }

    public function testDeleteHistoryNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Sejarah desa tidak ditemukan');

        $this->service->deleteHistory(99999);
    }

    // ==========================================================
    // VISION & MISSION TESTS
    // ==========================================================

    public function testCreateVisionMissionSuccess(): void
    {
        $item = new VillageVisionMission();
        $item->type = 'vision';
        $item->description = 'Visi Desa Bungur Maju';
        $item->sortOrder = 1;

        $created = $this->service->createVisionMission($item);

        $this->assertNotNull($created->id);
        $this->assertEquals('vision', $created->type);
        $this->assertEquals('Visi Desa Bungur Maju', $created->description);
        $this->assertEquals(1, $created->sortOrder);
    }

    public function testCreateVisionMissionWithInvalidType(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Tipe harus vision atau mission');

        $item = new VillageVisionMission();
        $item->type = 'invalid';
        $item->description = 'Test';
        $item->sortOrder = 1;

        $this->service->createVisionMission($item);
    }

    public function testCreateVisionMissionWithEmptyDescription(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Deskripsi visi/misi tidak boleh kosong');

        $item = new VillageVisionMission();
        $item->type = 'vision';
        $item->description = '';
        $item->sortOrder = 1;

        $this->service->createVisionMission($item);
    }

    public function testUpdateVisionMissionSuccess(): void
    {
        $item = new VillageVisionMission();
        $item->type = 'vision';
        $item->description = 'Visi Desa Bungur';
        $item->sortOrder = 1;
        $created = $this->service->createVisionMission($item);

        $created->type = 'mission';
        $created->description = 'Misi Desa Bungur Update';
        $created->sortOrder = 2;

        $updated = $this->service->updateVisionMission($created);

        $this->assertEquals('mission', $updated->type);
        $this->assertEquals('Misi Desa Bungur Update', $updated->description);
        $this->assertEquals(2, $updated->sortOrder);
    }

    public function testUpdateVisionMissionNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data visi/misi tidak ditemukan');

        $item = new VillageVisionMission();
        $item->id = 99999;
        $item->type = 'vision';
        $item->description = 'Test';
        $item->sortOrder = 1;

        $this->service->updateVisionMission($item);
    }

    public function testGetAllVisionMissionsSuccess(): void
    {
        $item1 = new VillageVisionMission();
        $item1->type = 'vision';
        $item1->description = 'Visi 1';
        $item1->sortOrder = 1;
        $this->service->createVisionMission($item1);

        $item2 = new VillageVisionMission();
        $item2->type = 'mission';
        $item2->description = 'Misi 1';
        $item2->sortOrder = 1;
        $this->service->createVisionMission($item2);

        $items = $this->service->getAllVisionMissions();

        $this->assertCount(2, $items);
        $this->assertEquals('vision', $items[0]->type);
        $this->assertEquals('mission', $items[1]->type);
    }

    public function testGetVisionsSuccess(): void
    {
        $item1 = new VillageVisionMission();
        $item1->type = 'vision';
        $item1->description = 'Visi 1';
        $item1->sortOrder = 1;
        $this->service->createVisionMission($item1);

        $item2 = new VillageVisionMission();
        $item2->type = 'mission';
        $item2->description = 'Misi 1';
        $item2->sortOrder = 1;
        $this->service->createVisionMission($item2);

        $visions = $this->service->getVisions();

        $this->assertCount(1, $visions);
        $this->assertEquals('vision', $visions[0]->type);
        $this->assertEquals('Visi 1', $visions[0]->description);
    }

    public function testGetMissionsSuccess(): void
    {
        $item1 = new VillageVisionMission();
        $item1->type = 'vision';
        $item1->description = 'Visi 1';
        $item1->sortOrder = 1;
        $this->service->createVisionMission($item1);

        $item2 = new VillageVisionMission();
        $item2->type = 'mission';
        $item2->description = 'Misi 1';
        $item2->sortOrder = 1;
        $this->service->createVisionMission($item2);

        $missions = $this->service->getMissions();

        $this->assertCount(1, $missions);
        $this->assertEquals('mission', $missions[0]->type);
        $this->assertEquals('Misi 1', $missions[0]->description);
    }

    public function testDeleteVisionMissionSuccess(): void
    {
        $item = new VillageVisionMission();
        $item->type = 'vision';
        $item->description = 'Visi Desa Bungur';
        $item->sortOrder = 1;
        $created = $this->service->createVisionMission($item);

        $this->service->deleteVisionMission($created->id);

        $found = $this->service->getVisionMissionById($created->id);
        $this->assertNull($found);
    }

    public function testDeleteVisionMissionNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data visi/misi tidak ditemukan');

        $this->service->deleteVisionMission(99999);
    }

    // ==========================================================
    // DASHBOARD SUMMARY TESTS
    // ==========================================================

    public function testGetDashboardSummarySuccess(): void
    {
        // Create officials
        $official1 = new VillageOfficial();
        $official1->name = 'Ahmad Fauzi';
        $official1->position = 'Kepala Desa';
        $official1->period = '2021-2026';
        $official1->isActive = true;
        $this->service->createOfficial($official1);

        $official2 = new VillageOfficial();
        $official2->name = 'Budi Santoso';
        $official2->position = 'Sekretaris Desa';
        $official2->period = '2021-2026';
        $official2->isActive = false;
        $this->service->createOfficial($official2);

        // Create histories
        $history = new VillageHistory();
        $history->year = 1923;
        $history->title = 'Awal Berdirinya Desa';
        $history->description = 'Deskripsi';
        $this->service->createHistory($history);

        // Create visions & missions
        $vision = new VillageVisionMission();
        $vision->type = 'vision';
        $vision->description = 'Visi Desa';
        $vision->sortOrder = 1;
        $this->service->createVisionMission($vision);

        $mission = new VillageVisionMission();
        $mission->type = 'mission';
        $mission->description = 'Misi Desa';
        $mission->sortOrder = 1;
        $this->service->createVisionMission($mission);

        $summary = $this->service->getDashboardSummary();

        $this->assertArrayHasKey('total_officials', $summary);
        $this->assertArrayHasKey('active_officials', $summary);
        $this->assertArrayHasKey('total_histories', $summary);
        $this->assertArrayHasKey('total_visions', $summary);
        $this->assertArrayHasKey('total_missions', $summary);

        $this->assertEquals(2, $summary['total_officials']);
        $this->assertEquals(1, $summary['active_officials']);
        $this->assertEquals(1, $summary['total_histories']);
        $this->assertEquals(1, $summary['total_visions']);
        $this->assertEquals(1, $summary['total_missions']);
    }

    public function testGetDashboardSummaryEmpty(): void
    {
        $summary = $this->service->getDashboardSummary();

        $this->assertEquals(0, $summary['total_officials']);
        $this->assertEquals(0, $summary['active_officials']);
        $this->assertEquals(0, $summary['total_histories']);
        $this->assertEquals(0, $summary['total_visions']);
        $this->assertEquals(0, $summary['total_missions']);
    }
}