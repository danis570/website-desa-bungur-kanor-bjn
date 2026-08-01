<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Umkm;
use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmMenu;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmMenuRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;

class UmkmService
{
    private UmkmRepository $umkmRepository;
    private UmkmCategoryRepository $categoryRepository;
    private UmkmMenuRepository $menuRepository;

    public function __construct(
        UmkmRepository $umkmRepository,
        UmkmCategoryRepository $categoryRepository,
        UmkmMenuRepository $menuRepository
    ) {
        $this->umkmRepository = $umkmRepository;
        $this->categoryRepository = $categoryRepository;
        $this->menuRepository = $menuRepository;
    }

    public function create(UmkmCreateRequest $request): Umkm
    {
        $this->validateCreateRequest($request);

        // Check if category exists
        $category = $this->categoryRepository->findById($request->categoryId);
        if ($category === null) {
            throw new ValidationException('Kategori tidak ditemukan');
        }

        $umkm = new Umkm();
        $umkm->categoryId = $request->categoryId;
        $umkm->name = $request->name;
        $umkm->owner = $request->owner;
        $umkm->ownerPhoto = $request->ownerPhoto ?? null;
        $umkm->featuredImage = $request->featuredImage ?? null;
        $umkm->description = $request->description ?? null;
        $umkm->address = $request->address ?? null;
        $umkm->businessHours = $request->businessHours ?? null;
        $umkm->whatsapp = $request->whatsapp ?? null;
        $umkm->mapsEmbedUrl = $request->mapsEmbedUrl ?? null;

        $savedUmkm = $this->umkmRepository->save($umkm);

        // Save menus
        if (!empty($request->menus)) {
            foreach ($request->menus as $menuData) {
                $menu = new UmkmMenu();
                $menu->umkmId = $savedUmkm->id;
                $menu->name = $menuData['name'];
                $menu->price = $menuData['price'];
                $menu->image = $menuData['image'] ?? null;
                $this->menuRepository->save($menu);
            }
        }

        // Load menus
        $savedUmkm->menus = $this->menuRepository->findByUmkmId($savedUmkm->id);

        return $savedUmkm;
    }

    public function update(UmkmUpdateRequest $request): Umkm
    {
        $this->validateUpdateRequest($request);

        // Check if UMKM exists
        $existingUmkm = $this->umkmRepository->findById($request->id);
        if ($existingUmkm === null) {
            throw new ValidationException('UMKM tidak ditemukan');
        }

        // Check if category exists
        $category = $this->categoryRepository->findById($request->categoryId);
        if ($category === null) {
            throw new ValidationException('Kategori tidak ditemukan');
        }

        $umkm = new Umkm();
        $umkm->id = $request->id;
        $umkm->categoryId = $request->categoryId;
        $umkm->name = $request->name;
        $umkm->owner = $request->owner;
        $umkm->ownerPhoto = $request->ownerPhoto ?? $existingUmkm->ownerPhoto;
        $umkm->featuredImage = $request->featuredImage ?? $existingUmkm->featuredImage;
        $umkm->description = $request->description ?? null;
        $umkm->address = $request->address ?? null;
        $umkm->businessHours = $request->businessHours ?? null;
        $umkm->whatsapp = $request->whatsapp ?? null;
        $umkm->mapsEmbedUrl = $request->mapsEmbedUrl ?? null;

        $updatedUmkm = $this->umkmRepository->update($umkm);

        // Handle menus - delete all existing menus
        $this->menuRepository->deleteByUmkmId($updatedUmkm->id);

        // Save new menus
        if (!empty($request->menus)) {
            foreach ($request->menus as $menuData) {
                $menu = new UmkmMenu();
                $menu->umkmId = $updatedUmkm->id;
                $menu->name = $menuData['name'];
                $menu->price = $menuData['price'];
                $menu->image = $menuData['image'] ?? null;
                $this->menuRepository->save($menu);
            }
        }

        // Load menus
        $updatedUmkm->menus = $this->menuRepository->findByUmkmId($updatedUmkm->id);

        return $updatedUmkm;
    }

    public function findById(int $id): ?Umkm
    {
        $umkm = $this->umkmRepository->findById($id);
        if ($umkm !== null) {
            $umkm->menus = $this->menuRepository->findByUmkmId($id);
        }
        return $umkm;
    }

    public function findAll(): array
    {
        $umkms = $this->umkmRepository->findAll();
        foreach ($umkms as $umkm) {
            $umkm->menus = $this->menuRepository->findByUmkmId($umkm->id);
        }
        return $umkms;
    }

    public function findByCategoryId(int $categoryId): array
    {
        $category = $this->categoryRepository->findById($categoryId);
        if ($category === null) {
            throw new ValidationException('Kategori tidak ditemukan');
        }

        $umkms = $this->umkmRepository->findByCategoryId($categoryId);
        foreach ($umkms as $umkm) {
            $umkm->menus = $this->menuRepository->findByUmkmId($umkm->id);
        }
        return $umkms;
    }

    public function delete(int $id): void
    {
        $umkm = $this->umkmRepository->findById($id);
        if ($umkm === null) {
            throw new ValidationException('UMKM tidak ditemukan');
        }

        // Delete all menus first
        $this->menuRepository->deleteByUmkmId($id);
        
        // Then soft delete UMKM
        $this->umkmRepository->softDelete($id);
    }

    private function validateCreateRequest(UmkmCreateRequest $request): void
    {
        if (empty(trim($request->name ?? ''))) {
            throw new ValidationException('Nama UMKM tidak boleh kosong');
        }

        if (empty(trim($request->owner ?? ''))) {
            throw new ValidationException('Nama pemilik tidak boleh kosong');
        }

        if ($request->categoryId <= 0) {
            throw new ValidationException('Kategori tidak valid');
        }
    }

    private function validateUpdateRequest(UmkmUpdateRequest $request): void
    {
        if ($request->id <= 0) {
            throw new ValidationException('ID tidak valid');
        }

        if (empty(trim($request->name ?? ''))) {
            throw new ValidationException('Nama UMKM tidak boleh kosong');
        }

        if (empty(trim($request->owner ?? ''))) {
            throw new ValidationException('Nama pemilik tidak boleh kosong');
        }

        if ($request->categoryId <= 0) {
            throw new ValidationException('Kategori tidak valid');
        }
    }
}