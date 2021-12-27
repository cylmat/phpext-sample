<?php

declare(strict_types=1);

namespace Phpext\Php\Auth;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call()
    {
        // @todo
    }

    public function basic()
    {
        (new Digest())->handleBasic();
    }

    public function digest()
    {
        (new Digest())->handleDigest();
    }
}
