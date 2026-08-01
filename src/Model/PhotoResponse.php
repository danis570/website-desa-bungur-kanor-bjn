<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Photo;

class PhotoResponse
{
    public Photo $photo;

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }
}
