<?php

declare(strict_types=1);

namespace Phpext\Php\Auth;

use Phpext\CallableInterface;

/**
 * Create Htdigest
 *   htdigest -c data/users.htdigest "Secure API" ralph
 */

class Auth implements CallableInterface
{
    public function call(): array
    {
        return [
            $this->basic(),
            $this->digest(),
        ];
    }

    private function basic()
    {
        (new Digest())->handleBasic();
    }

    private function digest()
    {
        (new Digest())->handleDigest();
    }
}
