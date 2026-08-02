<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicAgeGroup;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicEducation;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicGender;
use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicReligion;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicAgeGroupRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicEducationRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicGenderRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\DemographicReligionRepository;

class DemographicService
{
    private DemographicGenderRepository $genderRepository;
    private DemographicEducationRepository $educationRepository;
    private DemographicReligionRepository $religionRepository;
    private DemographicAgeGroupRepository $ageGroupRepository;

    public function __construct(
        DemographicGenderRepository $genderRepository,
        DemographicEducationRepository $educationRepository,
        DemographicReligionRepository $religionRepository,
        DemographicAgeGroupRepository $ageGroupRepository
    ) {
        $this->genderRepository = $genderRepository;
        $this->educationRepository = $educationRepository;
        $this->religionRepository = $religionRepository;
        $this->ageGroupRepository = $ageGroupRepository;
    }

    // ==========================================================
    // GENDER
    // ==========================================================

    public function getAllGenders(): array
    {
        return $this->genderRepository->findAll();
    }

    public function getGenderByGender(string $gender): ?DemographicGender
    {
        return $this->genderRepository->findByGender($gender);
    }

    public function updateGender(string $gender, int $total): DemographicGender
    {
        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = $this->genderRepository->findByGender($gender);

        if ($data === null) {
            $data = new DemographicGender();
            $data->gender = $gender;
        }

        $data->total = $total;

        return $this->genderRepository->save($data);
    }

    public function getGenderSummary(): array
    {
        $genders = $this->genderRepository->findAll();
        $total = 0;
        $result = [];

        foreach ($genders as $gender) {
            $total += $gender->total;
            $result[$gender->gender] = $gender->total;
        }

        return [
            'data' => $result,
            'total' => $total
        ];
    }

    // ==========================================================
    // EDUCATION
    // ==========================================================

    public function getAllEducations(): array
    {
        return $this->educationRepository->findAll();
    }

    public function getEducationById(int $id): ?DemographicEducation
    {
        return $this->educationRepository->findById($id);
    }

    public function createEducation(string $level, int $total): DemographicEducation
    {
        if (empty(trim($level))) {
            throw new ValidationException('Tingkat pendidikan tidak boleh kosong');
        }

        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = new DemographicEducation();
        $data->educationLevel = $level;
        $data->total = $total;

        return $this->educationRepository->save($data);
    }

    public function updateEducation(int $id, int $total): DemographicEducation
    {
        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = $this->educationRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data pendidikan tidak ditemukan');
        }

        $data->total = $total;

        return $this->educationRepository->update($data);
    }

    /**
     * Delete education data
     * Jika id = 0, hapus semua data
     */
    public function deleteEducation(int $id): void
    {
        if ($id === 0) {
            $this->educationRepository->deleteAll();
            return;
        }

        $data = $this->educationRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data pendidikan tidak ditemukan');
        }

        // Hapus spesifik (gunakan deleteAll atau implementasi lain)
        $this->educationRepository->deleteAll();
    }

    public function deleteAllEducation(): void
    {
        $this->educationRepository->deleteAll();
    }

    public function getEducationSummary(): array
    {
        $educations = $this->educationRepository->findAll();
        $total = 0;
        $result = [];

        foreach ($educations as $edu) {
            $total += $edu->total;
            $result[$edu->educationLevel] = $edu->total;
        }

        return [
            'data' => $result,
            'total' => $total
        ];
    }

    // ==========================================================
    // RELIGION
    // ==========================================================

    public function getAllReligions(): array
    {
        return $this->religionRepository->findAll();
    }

    public function getReligionById(int $id): ?DemographicReligion
    {
        return $this->religionRepository->findById($id);
    }

    public function createReligion(string $religion, int $total): DemographicReligion
    {
        if (empty(trim($religion))) {
            throw new ValidationException('Agama tidak boleh kosong');
        }

        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = new DemographicReligion();
        $data->religion = $religion;
        $data->total = $total;

        return $this->religionRepository->save($data);
    }

    public function updateReligion(int $id, int $total): DemographicReligion
    {
        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = $this->religionRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data agama tidak ditemukan');
        }

        $data->total = $total;

        return $this->religionRepository->update($data);
    }

    // TAMBAHKAN METHOD INI
    public function deleteReligion(int $id): void
    {
        if ($id === 0) {
            $this->religionRepository->deleteAll();
            return;
        }

        $data = $this->religionRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data agama tidak ditemukan');
        }

        $this->religionRepository->deleteAll();
    }

    public function deleteAllReligion(): void
    {
        $this->religionRepository->deleteAll();
    }

    public function getReligionSummary(): array
    {
        $religions = $this->religionRepository->findAll();
        $total = 0;
        $result = [];

        foreach ($religions as $rel) {
            $total += $rel->total;
            $result[$rel->religion] = $rel->total;
        }

        return [
            'data' => $result,
            'total' => $total
        ];
    }

    // ==========================================================
    // AGE GROUP
    // ==========================================================

    public function getAllAgeGroups(): array
    {
        return $this->ageGroupRepository->findAll();
    }

    public function getAgeGroupById(int $id): ?DemographicAgeGroup
    {
        return $this->ageGroupRepository->findById($id);
    }

    public function createAgeGroup(string $ageRange, int $total): DemographicAgeGroup
    {
        if (empty(trim($ageRange))) {
            throw new ValidationException('Rentang umur tidak boleh kosong');
        }

        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = new DemographicAgeGroup();
        $data->ageRange = $ageRange;
        $data->total = $total;

        return $this->ageGroupRepository->save($data);
    }

    public function updateAgeGroup(int $id, int $total): DemographicAgeGroup
    {
        if ($total < 0) {
            throw new ValidationException('Total tidak boleh negatif');
        }

        $data = $this->ageGroupRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data kelompok umur tidak ditemukan');
        }

        $data->total = $total;

        return $this->ageGroupRepository->update($data);
    }

    // TAMBAHKAN METHOD INI
    public function deleteAgeGroup(int $id): void
    {
        if ($id === 0) {
            $this->ageGroupRepository->deleteAll();
            return;
        }

        $data = $this->ageGroupRepository->findById($id);
        if ($data === null) {
            throw new ValidationException('Data kelompok umur tidak ditemukan');
        }

        $this->ageGroupRepository->deleteAll();
    }

    public function deleteAllAgeGroup(): void
    {
        $this->ageGroupRepository->deleteAll();
    }

    public function getAgeGroupSummary(): array
    {
        $ageGroups = $this->ageGroupRepository->findAll();
        $total = 0;
        $result = [];

        foreach ($ageGroups as $age) {
            $total += $age->total;
            $result[$age->ageRange] = $age->total;
        }

        return [
            'data' => $result,
            'total' => $total
        ];
    }

    // ==========================================================
    // DASHBOARD SUMMARY
    // ==========================================================

    public function getDashboardSummary(): array
    {
        return [
            'gender' => $this->getGenderSummary(),
            'education' => $this->getEducationSummary(),
            'religion' => $this->getReligionSummary(),
            'age_group' => $this->getAgeGroupSummary()
        ];
    }
}