<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

use Phpext\DisplayInterface;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class Index implements DisplayInterface
{
    public function call()
    {
        
    }

    public function send()
    {
        (new Curl())->request();
        (new Curl())->api();
    }
}
