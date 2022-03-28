<?php

declare(strict_types=1);

namespace Phpext\Php\Header;

use Phpext\AbstractCallable;

class Index extends AbstractCallable
{
    public function call(): array
    {
        return [];
    }
}