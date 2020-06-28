<?php declare(strict_types = 1);

namespace Curl;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class Index
{
    public function send()
    {
        (new Curl)->request();
        (new Curl)->api();
    }
}

