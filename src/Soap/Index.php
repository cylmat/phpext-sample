<?php 

declare(strict_types = 1);

namespace Soap;

class Index
{
    public function index()
    {
        $params = (func_get_args());
        echo 'Call SoapClient<br/>';
        (new Client)->call($params);
    }

    public function server()
    {
        (new Server)->handle();
    }
}