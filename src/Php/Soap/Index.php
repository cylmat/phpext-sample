<?php

declare(strict_types=1);

namespace Phpext\Php\Soap;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call()
    {
        // @todo
    }

    public function client()
    {
        //echo 'Call SoapClient<br/>';
        $c = new Client();
        $c->create();
        $c->call(["Salut!"]);
    }
}
