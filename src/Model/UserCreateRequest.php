<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Model;

class UserCreateRequest
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $avatar = null;
    public ?string $position = null;
    public ?string $role = null;
}