<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class VillageVisionMission
{
    public ?int $id = null;
    public string $type; // 'vision' or 'mission'
    public string $description;
    public int $sortOrder = 0;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
}