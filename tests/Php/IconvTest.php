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

    public function test() 
    {
        $res = $this->index->call();

        $this->assertArrayHasKey('intl', $res);
        $this->assertArrayHasKey('gettext', $res);
    }

    /**
     * @group display
     */
    public function testDisplay()
    {
        var_dump($this->index->call());
    }
}
