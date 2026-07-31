<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Domain;

class User
{
    public ?int $id = null;

    public string $name;

    public string $email;

    public string $password;
    public ?string $avatar = null;

    public ?string $position = null;

    public string $role = 'user';

    public ?string $createdAt = null;

    public ?string $updatedAt = null;

    public ?string $deletedAt = null;
}
