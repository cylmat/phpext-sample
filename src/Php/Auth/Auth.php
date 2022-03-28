<?php

declare(strict_types=1);

namespace Phpext\Php\Auth;

use Phpext\AbstractCallable;

class Auth extends AbstractCallable
{
    public function call(): array
    {
        return [
            $this->basic(),
            $this->digest(),
        ];
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
