<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

use Phpext\AbstractCallable;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class Index extends AbstractCallable
{
    public function call(): array
    {
        return [];
    }

    public function send()
    {
        (new Curl())->request();
        (new Curl())->api();
    }
}
