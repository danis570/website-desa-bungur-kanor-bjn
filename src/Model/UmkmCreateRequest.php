<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class UmkmCreateRequest
{
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
    public array $menus = [];
}