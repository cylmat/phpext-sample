<?php

declare(strict_types=1);

namespace Soap;

class Index
{
    public function client()
    {
        //echo 'Call SoapClient<br/>';
        $c = new Client();
        $c->create();
        $c->call(["Salut!"]);
    }
}
