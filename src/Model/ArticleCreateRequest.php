<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class ArticleCreateRequest
{
    public string $title;
    public int $userId;
    public int $categoryId;
    public string $content;
    public string $status = 'draft';
    public ?string $excerpt = null;
    public ?string $image = null;
}