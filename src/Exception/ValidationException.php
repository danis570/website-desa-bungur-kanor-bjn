<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Exception;

use Exception;

class ValidationException extends Exception
{
    public static function required(string $field): self
    {
        return new self("$field tidak boleh kosong.");
    }

    public static function invalidEmail(): self
    {
        return new self("Format email tidak valid.");
    }

    public static function emailAlreadyExists(): self
    {
        return new self("Email sudah digunakan.");
    }

    public static function passwordTooShort(int $min = 8): self
    {
        return new self("Password minimal {$min} karakter.");
    }

    public static function invalidRole(): self
    {
        return new self("Role tidak valid.");
    }
}
