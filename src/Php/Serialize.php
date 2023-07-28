<?php

declare(strict_types=1);

namespace Phpext\Php;

use Phpext\CallableInterface;

class Serialize implements CallableInterface
{
    public function call(): array
    {
        return [
          $this->serialize(),
        ];
    }

    private function serialize()
    {
        
    }
}
