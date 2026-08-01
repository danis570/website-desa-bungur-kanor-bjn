<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class UpdatePhotoRequest
{
    public int $id;
    public string $caption;
    public string $location;
    public ?string $image = null; // <-- TAMBAHKAN INI

    public function __construct(int $id, string $caption, string $location)
    {
        $this->id = $id;
        $this->caption = $caption;
        $this->location = $location;
    }
}