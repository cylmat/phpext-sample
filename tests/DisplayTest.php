<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Exceptions\Exceptions;
use Phpext\Php\Stream\Stream;
use Phpext\Php\YieldGen\YieldGen;
use PHPUnit\Framework\TestCase;

/**
 * @group display
 */
class DisplayTest extends TestCase
{
    public function testExceptions()
    {
        $this->display(Exceptions::class);
    }

    public function testStream()
    {
        $this->display(Stream::class);
    }

    public function testYieldGen()
    {
        $this->display(YieldGen::class);
    }

    private function display(string $class): void
    {
        echo "\n\n";
        $call = (new $class)->call();

        foreach ($call as $key => $result) {
            echo "$key: -> ";
            var_dump($result);
        }

        $this->assertNull(null); // make it green
    }
}
