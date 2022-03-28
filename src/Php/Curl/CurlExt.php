<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

use Phpext\AbstractCallable;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class CurlExt extends AbstractCallable
{
    public function call(): array
    {
        return [
            $this->send()
        ];
    }

    public function send()
    {
        (new CurlTry())->request();
        (new CurlTry())->api();
    }
}
