<?php

declare(strict_types=1);

namespace Phpext\Php\Auth;

use Phpext\CallableInterface;

class Index implements CallableInterface
{
    public function call(): array
    {
        // @todo
        return [];
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
