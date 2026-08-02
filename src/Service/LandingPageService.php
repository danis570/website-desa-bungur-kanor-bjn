<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\HeroBanner;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageGreeting;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\HeroBannerRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;

class LandingPageService
{
    private HeroBannerRepository $bannerRepository;
    private VillageGreetingRepository $greetingRepository;

    public function __construct(
        HeroBannerRepository $bannerRepository,
        VillageGreetingRepository $greetingRepository
    ) {
        $this->bannerRepository = $bannerRepository;
        $this->greetingRepository = $greetingRepository;
    }

    // ==========================================================
    // HERO BANNERS
    // ==========================================================

    public function createBanner(HeroBanner $banner): HeroBanner
    {
        $this->validateBanner($banner);
        return $this->bannerRepository->save($banner);
    }

    public function updateBanner(HeroBanner $banner): HeroBanner
    {
        $this->validateBanner($banner);

        $existing = $this->bannerRepository->findById($banner->id);
        if ($existing === null) {
            throw new ValidationException('Banner tidak ditemukan');
        }

        return $this->bannerRepository->update($banner);
    }

    public function getBannerById(int $id): ?HeroBanner
    {
        return $this->bannerRepository->findById($id);
    }

    public function getAllBanners(): array
    {
        return $this->bannerRepository->findAll();
    }

    public function deleteBanner(int $id): void
    {
        $banner = $this->bannerRepository->findById($id);
        if ($banner === null) {
            throw new ValidationException('Banner tidak ditemukan');
        }

        // Hapus file gambar jika ada
        if ($banner->image) {
            $this->deleteImage($banner->image, 'banner');
        }

        $this->bannerRepository->softDelete($id);
    }

    private function validateBanner(HeroBanner $banner): void
    {
        if (empty(trim($banner->title))) {
            throw new ValidationException('Judul banner tidak boleh kosong');
        }

        if (empty(trim($banner->image))) {
            throw new ValidationException('Gambar banner tidak boleh kosong');
        }
    }

    // ==========================================================
    // VILLAGE GREETINGS
    // ==========================================================

    public function createGreeting(VillageGreeting $greeting): VillageGreeting
    {
        $this->validateGreeting($greeting);
        return $this->greetingRepository->save($greeting);
    }

    public function updateGreeting(VillageGreeting $greeting): VillageGreeting
    {
        $this->validateGreeting($greeting);

        $existing = $this->greetingRepository->findById($greeting->id);
        if ($existing === null) {
            throw new ValidationException('Sambutan tidak ditemukan');
        }

        return $this->greetingRepository->update($greeting);
    }

    public function getGreetingById(int $id): ?VillageGreeting
    {
        return $this->greetingRepository->findById($id);
    }

    public function getFirstGreeting(): ?VillageGreeting
    {
        return $this->greetingRepository->findFirst();
    }

    public function getAllGreetings(): array
    {
        return $this->greetingRepository->findAll();
    }

    public function deleteGreeting(int $id): void
    {
        $greeting = $this->greetingRepository->findById($id);
        if ($greeting === null) {
            throw new ValidationException('Sambutan tidak ditemukan');
        }

        // Hapus file gambar jika ada
        if ($greeting->image) {
            $this->deleteImage($greeting->image, 'greeting');
        }
        if ($greeting->signatureImage) {
            $this->deleteImage($greeting->signatureImage, 'signature');
        }

        $this->greetingRepository->softDelete($id);
    }

    private function validateGreeting(VillageGreeting $greeting): void
    {
        if (empty(trim($greeting->name))) {
            throw new ValidationException('Nama tidak boleh kosong');
        }

        if (empty(trim($greeting->content))) {
            throw new ValidationException('Isi sambutan tidak boleh kosong');
        }
    }

    // ==========================================================
    // HELPERS
    // ==========================================================

    private function deleteImage(?string $filename, string $folder): void
    {
        if (empty($filename)) {
            return;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/' . $folder . '/';
        $filePath = $uploadDir . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function getDashboardSummary(): array
    {
        return [
            'total_banners' => count($this->bannerRepository->findAll()),
            'total_greetings' => count($this->greetingRepository->findAll()),
        ];
    }
}