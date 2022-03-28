<?php

declare(strict_types=1);

namespace Phpext\Php\Soap;

use Phpext\AbstractCallable;

class Index extends AbstractCallable
{
    public function call(): array
    {
        // @todo

        return [];
    }

    public function client()
    {
        //echo 'Call SoapClient<br/>';
        $c = new Client();
        $c->create();
        $c->call(["Salut!"]);
    }
}
