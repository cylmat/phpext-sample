<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Iconv\Index;
use PHPUnit\Framework\TestCase;

class IconvTest extends TestCase
{
    protected Index $index;

    protected function setUp(): void
    {
        $this->index = new Index;
    }

    public function testCall()
    {
        $this->index->call();
    }

    /**
     * @group display
     */
    public function testDisplay()
    {
        var_dump($this->index->call());
    }
}
