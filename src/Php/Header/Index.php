<?php

declare(strict_types=1);

namespace Phpext\Php\Header;

use Phpext\CallableInterface;

class Index implements CallableInterface
{
    public function call(): array
    {
        return [];
    }
}