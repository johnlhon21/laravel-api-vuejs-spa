<?php
namespace App\Security;

use Illuminate\Support\Facades\Hash;

class Password
{
    public function hash(string $str): string
    {
        return Hash::make($str);
    }

    public function isValidPassword($str, $hashed): bool
    {
        return Hash::check($str, $hashed);
    }
}
