<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class VillageOfficial
{
    public ?int $id = null;
    public string $name;
    public string $position;
    public ?string $photo = null;
    public string $period;
    public bool $isActive = true;
    public ?string $whatsapp = null;
    public ?string $facebook = null;
    public ?string $email = null;
    public ?string $mapsEmbedUrl = null;
    public ?string $address = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
}