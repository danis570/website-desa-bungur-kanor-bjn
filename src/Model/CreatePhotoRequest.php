<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class CreatePhotoRequest
{
    public string $caption;
    public string $location;
    public int $userId;
    public ?string $image = null; // <-- TAMBAHKAN INI

    public function __construct(string $caption, string $location, int $userId)
    {
        $this->caption = $caption;
        $this->location = $location;
        $this->userId = $userId;
    }
}