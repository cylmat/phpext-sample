<?php

declare(strict_types=1);

namespace Soap;

class ServerManager
{
    static $URI = 'http://192.168.99.100:89'; #'http://192.168.99.100:89/soap/index/server'

    public static function setURI(string $URI): void
    {
        self::$URI = $URI;
    }

    public function getMessage(string $strNom): string
    {
        return 'Here is your message: ' . $strNom;
    }
}
