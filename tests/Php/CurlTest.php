<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Curl\Index;
use PHPUnit\Framework\TestCase;

class CurlTest extends TestCase
{
    protected Index $index;

    protected function setUp(): void
    {
        $this->index = new Index;
    }

    public function testBasic() 
    {
        $this->index->call();
        //$this->expectOutputRegex('//');
    }

}
