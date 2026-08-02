<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class Article
{
    public ?int $id = null;

    public string $title;
    public string $slug;

    public int $userId;
    public int $categoryId;

    public ?string $authorName = null;
    public ?string $authorPosition = null;
    public ?string $authorAvatar = null;
    public ?string $categoryName = null;

    public ?string $excerpt = null;

    public string $status;

    public ?string $publishedAt = null;

    public ?string $image = null;
    public ?string $imageAlt = null;

    public string $content;

    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
}