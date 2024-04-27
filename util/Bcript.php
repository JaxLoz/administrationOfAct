<?php

namespace util;

class Bcript
{
    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyEncrypt(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}