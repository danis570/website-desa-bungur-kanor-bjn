<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Photo;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\CreatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\PhotoResponse;
use Kkn27Unirow\WebsiteDesaBungur\Model\UpdatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;

class PhotoService
{
    private PhotoRepository $photoRepository;
    private UserRepository $userRepository;

    public function __construct(PhotoRepository $photoRepository, UserRepository $userRepository)
    {
        $this->photoRepository = $photoRepository;
        $this->userRepository = $userRepository;
    }

    public function create(CreatePhotoRequest $request): PhotoResponse
    {
        $this->validateCreateRequest($request);

        $user = $this->userRepository->findById($request->userId);
        if ($user === null) {
            throw new ValidationException('User tidak ditemukan');
        }

        $photo = new Photo();
        $photo->caption = $request->caption;
        $photo->location = $request->location;
        $photo->userId = $request->userId;
        $photo->image = $request->image ?? null; // <-- TAMBAHKAN INI

        $savedPhoto = $this->photoRepository->save($photo);

        return new PhotoResponse($savedPhoto);
    }

    public function update(UpdatePhotoRequest $request): PhotoResponse
    {
        $this->validateUpdateRequest($request);

        $photo = $this->photoRepository->findById($request->id);
        if ($photo === null) {
            throw new ValidationException('Photo tidak ditemukan');
        }

        $photo->caption = $request->caption;
        $photo->location = $request->location;

        // Update image jika ada
        if ($request->image !== null) {
            $photo->image = $request->image;
        }

        $updatedPhoto = $this->photoRepository->update($photo);

        return new PhotoResponse($updatedPhoto);
    }

    public function findById(int $id): PhotoResponse
    {
        $photo = $this->photoRepository->findById($id);
        if ($photo === null) {
            throw new ValidationException('Photo tidak ditemukan');
        }

        return new PhotoResponse($photo);
    }

    public function findAll(): array
    {
        return $this->photoRepository->findAll();
    }

    public function findByUserId(int $userId): array
    {
        $user = $this->userRepository->findById($userId);
        if ($user === null) {
            throw new ValidationException('User tidak ditemukan');
        }

        return $this->photoRepository->findByUserId($userId);
    }

    public function delete(int $id): void
    {
        $photo = $this->photoRepository->findById($id);
        if ($photo === null) {
            throw new ValidationException('Photo tidak ditemukan');
        }

        $this->photoRepository->softDelete($id);
    }

    private function validateCreateRequest(CreatePhotoRequest $request): void
    {
        if ($request->caption === null || trim($request->caption) === '') {
            throw ValidationException::required('Caption');
        }

        if ($request->userId <= 0) {
            throw new ValidationException('User ID tidak valid.');
        }
    }

    private function validateUpdateRequest(UpdatePhotoRequest $request): void
    {
        if ($request->id <= 0) {
            throw new ValidationException('ID tidak valid.');
        }

        if ($request->caption === null || trim($request->caption) === '') {
            throw ValidationException::required('Caption');
        }
    }
}