<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class Umkm
{
    public ?int $id = null;
    public int $categoryId;
    public string $name;
    public string $owner;
    public ?string $ownerPhoto = null;
    public ?string $featuredImage = null;
    public ?string $description = null;
    public ?string $address = null;
    public ?string $businessHours = null;
    public ?string $whatsapp = null;
    public ?string $mapsEmbedUrl = null;
    public ?string $categoryName = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
    
    public array $menus = [];
}