<?php

declare(strict_types=1);

namespace Phpext\Php\Soap;

use Phpext\CallableInterface;

class Soap implements CallableInterface
{
    public function call(): array
    {
        // @todo

        return [];
    }

    private function client()
    {
        //echo 'Call SoapClient<br/>';
        $c = new Client();
        $c->create();
        $c->call(["Salut!"]);
    }
}
