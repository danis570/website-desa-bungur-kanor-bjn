<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class VillageHistory
{
    public ?int $id = null;
    public int $year;
    public string $title;
    public ?string $image = null;
    public string $description;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
}