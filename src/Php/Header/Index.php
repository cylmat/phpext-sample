<?php

declare(strict_types=1);

namespace Phpext\Php\Header;

use Phpext\DisplayInterface;

class Index implements DisplayInterface
{
    public function call(): array
    {
        return [];
    }
}