<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class ArticleUpdateRequest
{
    public int $id;
    public string $title;
    public int $categoryId;
    public string $content;
    public string $status = 'draft';
    public ?string $excerpt = null;
    public ?string $image = null;
     public ?string $imageAlt = null;
}
