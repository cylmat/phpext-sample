<?php

declare(strict_types=1);

namespace Phpext\Php\Curl;

use Phpext\CallableInterface;

/**
 * curl --header "X-MyHeader: 123" www.google.com
 */

class CurlExt implements CallableInterface
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
