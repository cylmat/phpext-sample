<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Phar\Index;
use PHPUnit\Framework\TestCase;

class PharTest extends TestCase
{
    protected Index $index;

    protected function setUp(): void
    {
        $this->index = new Index;
    }

    public function test() 
    {
    }

}
