<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageHistory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageOfficial;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageVisionMission;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;

class VillageProfileService
{
    private VillageOfficialRepository $officialRepository;
    private VillageHistoryRepository $historyRepository;
    private VillageVisionMissionRepository $visionMissionRepository;

    public function __construct(
        VillageOfficialRepository $officialRepository,
        VillageHistoryRepository $historyRepository,
        VillageVisionMissionRepository $visionMissionRepository
    ) {
        $this->officialRepository = $officialRepository;
        $this->historyRepository = $historyRepository;
        $this->visionMissionRepository = $visionMissionRepository;
    }

    // ==========================================================
    // OFFICIALS
    // ==========================================================

    public function createOfficial(VillageOfficial $official): VillageOfficial
    {
        $this->validateOfficial($official);
        return $this->officialRepository->save($official);
    }

    public function updateOfficial(VillageOfficial $official): VillageOfficial
    {
        $this->validateOfficial($official);

        $existing = $this->officialRepository->findById($official->id);
        if ($existing === null) {
            throw new ValidationException('Perangkat desa tidak ditemukan');
        }

        return $this->officialRepository->update($official);
    }


    public function getOfficialById(int $id): ?VillageOfficial
    {
        return $this->officialRepository->findById($id);
    }

    public function getAllOfficials(): array
    {
        return $this->officialRepository->findAll();
    }

    public function getActiveOfficials(): array
    {
        return $this->officialRepository->findActive();
    }

    public function deleteOfficial(int $id): void
    {
        $official = $this->officialRepository->findById($id);
        if ($official === null) {
            throw new ValidationException('Perangkat desa tidak ditemukan');
        }

        $this->officialRepository->softDelete($id);
    }

    private function validateOfficial(VillageOfficial $official): void
    {
        if (empty(trim($official->name))) {
            throw new ValidationException('Nama perangkat desa tidak boleh kosong');
        }

        if (empty(trim($official->position))) {
            throw new ValidationException('Jabatan tidak boleh kosong');
        }

        if (empty(trim($official->period))) {
            throw new ValidationException('Periode tidak boleh kosong');
        }
    }

    // ==========================================================
    // HISTORIES
    // ==========================================================

    public function createHistory(VillageHistory $history): VillageHistory
    {
        $this->validateHistory($history);
        return $this->historyRepository->save($history);
    }

    public function updateHistory(VillageHistory $history): VillageHistory
    {
        $this->validateHistory($history);

        $existing = $this->historyRepository->findById($history->id);
        if ($existing === null) {
            throw new ValidationException('Sejarah desa tidak ditemukan');
        }

        return $this->historyRepository->update($history);
    }

    public function getHistoryById(int $id): ?VillageHistory
    {
        return $this->historyRepository->findById($id);
    }

    public function getAllHistories(): array
    {
        return $this->historyRepository->findAll();
    }

    public function deleteHistory(int $id): void
    {
        $history = $this->historyRepository->findById($id);
        if ($history === null) {
            throw new ValidationException('Sejarah desa tidak ditemukan');
        }

        $this->historyRepository->softDelete($id);
    }

    private function validateHistory(VillageHistory $history): void
    {
        if ($history->year <= 0) {
            throw new ValidationException('Tahun tidak valid');
        }

        if (empty(trim($history->title))) {
            throw new ValidationException('Judul sejarah tidak boleh kosong');
        }

        if (empty(trim($history->description))) {
            throw new ValidationException('Deskripsi sejarah tidak boleh kosong');
        }
    }

    // ==========================================================
    // VISIONS & MISSIONS
    // ==========================================================

    public function createVisionMission(VillageVisionMission $item): VillageVisionMission
    {
        $this->validateVisionMission($item);
        return $this->visionMissionRepository->save($item);
    }

    public function updateVisionMission(VillageVisionMission $item): VillageVisionMission
    {
        $this->validateVisionMission($item);

        $existing = $this->visionMissionRepository->findById($item->id);
        if ($existing === null) {
            throw new ValidationException('Data visi/misi tidak ditemukan');
        }

        return $this->visionMissionRepository->update($item);
    }

    public function getVisionMissionById(int $id): ?VillageVisionMission
    {
        return $this->visionMissionRepository->findById($id);
    }

    public function getAllVisionMissions(): array
    {
        return $this->visionMissionRepository->findAll();
    }

    public function getVisions(): array
    {
        return $this->visionMissionRepository->findByType('vision');
    }

    public function getMissions(): array
    {
        return $this->visionMissionRepository->findByType('mission');
    }

    public function deleteVisionMission(int $id): void
    {
        $item = $this->visionMissionRepository->findById($id);
        if ($item === null) {
            throw new ValidationException('Data visi/misi tidak ditemukan');
        }

        $this->visionMissionRepository->softDelete($id);
    }

    public function deleteAllVisionMissions(): void
    {
        $this->visionMissionRepository->deleteAll();
    }

    private function validateVisionMission(VillageVisionMission $item): void
    {
        if (!in_array($item->type, ['vision', 'mission'])) {
            throw new ValidationException('Tipe harus vision atau mission');
        }

        if (empty(trim($item->description))) {
            throw new ValidationException('Deskripsi visi/misi tidak boleh kosong');
        }
    }

    // ==========================================================
    // DASHBOARD SUMMARY
    // ==========================================================

    public function getDashboardSummary(): array
    {
        return [
            'total_officials' => count($this->officialRepository->findAll()),
            'active_officials' => count($this->officialRepository->findActive()),
            'total_histories' => count($this->historyRepository->findAll()),
            'total_visions' => count($this->visionMissionRepository->findByType('vision')),
            'total_missions' => count($this->visionMissionRepository->findByType('mission'))
        ];
    }
}