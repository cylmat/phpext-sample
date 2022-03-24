<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Curl\Index;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2020-06-18 at 18:23:31.
 */
class CurlTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Index
     */
    protected $index;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->index = new Index;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void {}


    public function testBasic() 
    {
        $this->index->send();
        $this->expectOutputRegex('//');
    }

}
