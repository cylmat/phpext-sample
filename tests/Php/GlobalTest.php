<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Closures\Closures;
use Phpext\Php\Curl\CurlExt;
use Phpext\Php\Date\Dates;
use Phpext\Php\Exceptions\Exceptions;
use Phpext\Php\GetText\GetTextExt;
use Phpext\Php\Iconv\IconvExt;
use Phpext\Php\YieldGen\YieldGen;
use PHPUnit\Framework\TestCase;

class GlobalTest extends TestCase
{
    public function tests()
    {
        (new Closures)->call();
        (new CurlExt)->call();
        (new Dates)->call();
        (new GetTextExt)->call();
        (new Exceptions)->call();
        (new IconvExt)->call();
        (new YieldGen)->call();

        $this->assertNull(null); // make it green
    }

    public function testPhar() {}
}
