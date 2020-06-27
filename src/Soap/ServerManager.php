<?php declare(strict_types = 1);

namespace Soap;

class ServerManager
{
    const URI = 'http://192.168.99.100:89/soap/index/server/raw';

    public function getMessage(string $strNom): string
    {
        return 'Here is your message: ' . $strNom;
    }
}
