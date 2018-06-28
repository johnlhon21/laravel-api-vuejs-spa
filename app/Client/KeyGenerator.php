<?php
/**
 * Created by PhpStorm.
 * User: Marlon.Bagayawa
 * Date: 6/24/2018
 * Time: 2:27 AM
 */

namespace App\Client;


class KeyGenerator
{
    const API_KEY_LENGTH = 16;

    const SECRET_KEY_LENGTH = 32;

    public static function generate()
    {
        return new static();
    }

    public function apiKey(int $userId): string
    {
        $length = self::API_KEY_LENGTH - strlen((string)$userId);

        return $userId . $this->random($length);
    }

    public function secretKey(int $userId): string
    {
        $length = self::SECRET_KEY_LENGTH - strlen((string)$userId);

        return $userId . $this->random($length);
    }

    private function random(int $length): string
    {
        return str_random($length);
    }
}
