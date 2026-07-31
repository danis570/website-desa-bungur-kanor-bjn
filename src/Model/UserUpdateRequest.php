<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class UserUpdateRequest
{
    public ?int $id = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $position = null;

    public ?string $role = null;

    public ?string $avatar = null;
}