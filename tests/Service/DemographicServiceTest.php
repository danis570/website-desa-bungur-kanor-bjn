<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Tests\Service;

use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicAgeGroupRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicEducationRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicGenderRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicReligionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\DemographicService;
use PDO;
use PHPUnit\Framework\TestCase;

class DemographicServiceTest extends TestCase
{
    private PDO $pdo;
    private DemographicService $service;
    private DemographicGenderRepository $genderRepository;
    private DemographicEducationRepository $educationRepository;
    private DemographicReligionRepository $religionRepository;
    private DemographicAgeGroupRepository $ageGroupRepository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();

        $this->genderRepository = new DemographicGenderRepository($this->pdo);
        $this->educationRepository = new DemographicEducationRepository($this->pdo);
        $this->religionRepository = new DemographicReligionRepository($this->pdo);
        $this->ageGroupRepository = new DemographicAgeGroupRepository($this->pdo);

        $this->service = new DemographicService(
            $this->genderRepository,
            $this->educationRepository,
            $this->religionRepository,
            $this->ageGroupRepository
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
        $this->genderRepository->deleteAll();
        $this->educationRepository->deleteAll();
        $this->religionRepository->deleteAll();
        $this->ageGroupRepository->deleteAll();
        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    }

    // ==========================================================
    // GENDER TESTS
    // ==========================================================

    public function testUpdateGenderSuccess(): void
    {
        $gender = $this->service->updateGender('Laki-laki', 125);

        $this->assertNotNull($gender->id);
        $this->assertEquals('Laki-laki', $gender->gender);
        $this->assertEquals(125, $gender->total);

        $found = $this->service->getGenderByGender('Laki-laki');
        $this->assertNotNull($found);
        $this->assertEquals(125, $found->total);

        // Update
        $updated = $this->service->updateGender('Laki-laki', 150);
        $this->assertEquals(150, $updated->total);
    }

    public function testUpdateGenderWithNegativeTotal(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Total tidak boleh negatif');

        $this->service->updateGender('Laki-laki', -10);
    }

    public function testGetAllGendersSuccess(): void
    {
        $this->service->updateGender('Laki-laki', 125);
        $this->service->updateGender('Perempuan', 135);

        $genders = $this->service->getAllGenders();

        $this->assertCount(2, $genders);
        $this->assertEquals('Laki-laki', $genders[0]->gender);
        $this->assertEquals('Perempuan', $genders[1]->gender);
    }

    public function testGetAllGendersEmpty(): void
    {
        $genders = $this->service->getAllGenders();
        $this->assertEmpty($genders);
    }

    public function testGetGenderSummarySuccess(): void
    {
        $this->service->updateGender('Laki-laki', 125);
        $this->service->updateGender('Perempuan', 135);

        $summary = $this->service->getGenderSummary();

        $this->assertArrayHasKey('data', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertEquals(260, $summary['total']);
        $this->assertEquals(125, $summary['data']['Laki-laki']);
        $this->assertEquals(135, $summary['data']['Perempuan']);
    }

    // ==========================================================
    // EDUCATION TESTS
    // ==========================================================

    public function testCreateEducationSuccess(): void
    {
        $education = $this->service->createEducation('SD', 350);

        $this->assertNotNull($education->id);
        $this->assertEquals('SD', $education->educationLevel);
        $this->assertEquals(350, $education->total);
    }

    public function testCreateEducationWithEmptyLevel(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Tingkat pendidikan tidak boleh kosong');

        $this->service->createEducation('', 350);
    }

    public function testCreateEducationWithNegativeTotal(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Total tidak boleh negatif');

        $this->service->createEducation('SD', -10);
    }

    public function testUpdateEducationSuccess(): void
    {
        $education = $this->service->createEducation('SD', 350);

        $updated = $this->service->updateEducation($education->id, 400);

        $this->assertEquals(400, $updated->total);
    }

    public function testUpdateEducationNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data pendidikan tidak ditemukan');

        $this->service->updateEducation(99999, 400);
    }

    public function testUpdateEducationWithNegativeTotal(): void
    {
        $education = $this->service->createEducation('SD', 350);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Total tidak boleh negatif');

        $this->service->updateEducation($education->id, -10);
    }

    public function testGetAllEducationsSuccess(): void
    {
        $this->service->createEducation('SD', 350);
        $this->service->createEducation('SMP', 280);

        $educations = $this->service->getAllEducations();

        $this->assertCount(2, $educations);
        $this->assertEquals('SD', $educations[0]->educationLevel);
        $this->assertEquals('SMP', $educations[1]->educationLevel);
    }

    public function testGetEducationSummarySuccess(): void
    {
        $this->service->createEducation('SD', 350);
        $this->service->createEducation('SMP', 280);

        $summary = $this->service->getEducationSummary();

        $this->assertArrayHasKey('data', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertEquals(630, $summary['total']);
        $this->assertEquals(350, $summary['data']['SD']);
        $this->assertEquals(280, $summary['data']['SMP']);
    }

    public function testDeleteAllEducationSuccess(): void
    {
        $this->service->createEducation('SD', 350);
        $this->service->createEducation('SMP', 280);

        $this->service->deleteAllEducation();

        $educations = $this->service->getAllEducations();
        $this->assertEmpty($educations);
    }

    // ==========================================================
    // RELIGION TESTS
    // ==========================================================

    public function testCreateReligionSuccess(): void
    {
        $religion = $this->service->createReligion('Islam', 4050);

        $this->assertNotNull($religion->id);
        $this->assertEquals('Islam', $religion->religion);
        $this->assertEquals(4050, $religion->total);
    }

    public function testCreateReligionWithEmptyName(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Agama tidak boleh kosong');

        $this->service->createReligion('', 4050);
    }

    public function testCreateReligionWithNegativeTotal(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Total tidak boleh negatif');

        $this->service->createReligion('Islam', -10);
    }

    public function testUpdateReligionSuccess(): void
    {
        $religion = $this->service->createReligion('Islam', 4050);

        $updated = $this->service->updateReligion($religion->id, 4100);

        $this->assertEquals(4100, $updated->total);
    }

    public function testUpdateReligionNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data agama tidak ditemukan');

        $this->service->updateReligion(99999, 4100);
    }

    public function testGetAllReligionsSuccess(): void
    {
        $this->service->createReligion('Islam', 4050);
        $this->service->createReligion('Kristen', 35);

        $religions = $this->service->getAllReligions();

        $this->assertCount(2, $religions);
        $this->assertEquals('Islam', $religions[0]->religion);
        $this->assertEquals('Kristen', $religions[1]->religion);
    }

    public function testGetReligionSummarySuccess(): void
    {
        $this->service->createReligion('Islam', 4050);
        $this->service->createReligion('Kristen', 35);

        $summary = $this->service->getReligionSummary();

        $this->assertArrayHasKey('data', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertEquals(4085, $summary['total']);
        $this->assertEquals(4050, $summary['data']['Islam']);
        $this->assertEquals(35, $summary['data']['Kristen']);
    }

    public function testDeleteAllReligionSuccess(): void
    {
        $this->service->createReligion('Islam', 4050);
        $this->service->createReligion('Kristen', 35);

        $this->service->deleteAllReligion();

        $religions = $this->service->getAllReligions();
        $this->assertEmpty($religions);
    }

    // ==========================================================
    // AGE GROUP TESTS
    // ==========================================================

    public function testCreateAgeGroupSuccess(): void
    {
        $ageGroup = $this->service->createAgeGroup('0-5', 340);

        $this->assertNotNull($ageGroup->id);
        $this->assertEquals('0-5', $ageGroup->ageRange);
        $this->assertEquals(340, $ageGroup->total);
    }

    public function testCreateAgeGroupWithEmptyRange(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Rentang umur tidak boleh kosong');

        $this->service->createAgeGroup('', 340);
    }

    public function testCreateAgeGroupWithNegativeTotal(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Total tidak boleh negatif');

        $this->service->createAgeGroup('0-5', -10);
    }

    public function testUpdateAgeGroupSuccess(): void
    {
        $ageGroup = $this->service->createAgeGroup('0-5', 340);

        $updated = $this->service->updateAgeGroup($ageGroup->id, 350);

        $this->assertEquals(350, $updated->total);
    }

    public function testUpdateAgeGroupNotFound(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Data kelompok umur tidak ditemukan');

        $this->service->updateAgeGroup(99999, 350);
    }

    public function testGetAllAgeGroupsSuccess(): void
    {
        $this->service->createAgeGroup('0-5', 340);
        $this->service->createAgeGroup('6-12', 480);

        $ageGroups = $this->service->getAllAgeGroups();

        $this->assertCount(2, $ageGroups);
        $this->assertEquals('0-5', $ageGroups[0]->ageRange);
        $this->assertEquals('6-12', $ageGroups[1]->ageRange);
    }

    public function testGetAgeGroupSummarySuccess(): void
    {
        $this->service->createAgeGroup('0-5', 340);
        $this->service->createAgeGroup('6-12', 480);

        $summary = $this->service->getAgeGroupSummary();

        $this->assertArrayHasKey('data', $summary);
        $this->assertArrayHasKey('total', $summary);
        $this->assertEquals(820, $summary['total']);
        $this->assertEquals(340, $summary['data']['0-5']);
        $this->assertEquals(480, $summary['data']['6-12']);
    }

    public function testDeleteAllAgeGroupSuccess(): void
    {
        $this->service->createAgeGroup('0-5', 340);
        $this->service->createAgeGroup('6-12', 480);

        $this->service->deleteAllAgeGroup();

        $ageGroups = $this->service->getAllAgeGroups();
        $this->assertEmpty($ageGroups);
    }

    // ==========================================================
    // DASHBOARD SUMMARY TESTS
    // ==========================================================

    public function testGetDashboardSummarySuccess(): void
    {
        $this->service->updateGender('Laki-laki', 125);
        $this->service->updateGender('Perempuan', 135);
        $this->service->createEducation('SD', 350);
        $this->service->createEducation('SMP', 280);
        $this->service->createReligion('Islam', 4050);
        $this->service->createReligion('Kristen', 35);
        $this->service->createAgeGroup('0-5', 340);
        $this->service->createAgeGroup('6-12', 480);

        $summary = $this->service->getDashboardSummary();

        $this->assertArrayHasKey('gender', $summary);
        $this->assertArrayHasKey('education', $summary);
        $this->assertArrayHasKey('religion', $summary);
        $this->assertArrayHasKey('age_group', $summary);

        $this->assertEquals(260, $summary['gender']['total']);
        $this->assertEquals(630, $summary['education']['total']);
        $this->assertEquals(4085, $summary['religion']['total']);
        $this->assertEquals(820, $summary['age_group']['total']);
    }

    public function testGetDashboardSummaryEmpty(): void
    {
        $summary = $this->service->getDashboardSummary();

        $this->assertArrayHasKey('gender', $summary);
        $this->assertArrayHasKey('education', $summary);
        $this->assertArrayHasKey('religion', $summary);
        $this->assertArrayHasKey('age_group', $summary);

        $this->assertEquals(0, $summary['gender']['total']);
        $this->assertEquals(0, $summary['education']['total']);
        $this->assertEquals(0, $summary['religion']['total']);
        $this->assertEquals(0, $summary['age_group']['total']);
    }
}