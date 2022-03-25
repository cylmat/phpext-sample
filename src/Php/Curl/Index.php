<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

use Phpext\CallableInterface;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class Index implements CallableInterface
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
