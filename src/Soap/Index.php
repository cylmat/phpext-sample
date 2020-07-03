<?php

declare(strict_types=1);

namespace Soap;

class Index
{
    public function index()
    {
        //echo 'Call SoapClient<br/>';
        (new Client())->call(["Salut!"]);
    }
}
