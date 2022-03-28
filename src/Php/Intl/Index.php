<?php

declare(strict_types=1);

namespace Phpext\Php\Intl;

use Phpext\AbstractCallable;

class Index extends AbstractCallable
{
    public function call(): array
    {
        return [
            $this->printed()
        ];
    }

    public function printed(): array
    {
        return [
            sprintf('%x', \IntlChar::CODEPOINT_MAX),
            sprintf('%x', \IntlChar::charName('@')),
            sprintf('%x', \IntlChar::ispunct('!')),
        ];
    }
}