<?php

namespace Phpext\tests\Php;

use \PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator 
 */
class YieldGenTest extends TestCase
{
    /**
     * @var Index
     */
    protected $manager;
    protected $taskRunner;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->i = new Index;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void {}

    public function testUseGen() 
    {
        $this->i->yielding();
        $this->expectOutputRegex('/first:0/');
    }

    public function testUseGen2() 
    {
        $this->i->yielding2();
        $this->expectOutputRegex('/0:1:2:3:4:5/');
    }

    public function testTaskRunner() 
    {
        $this->i->tasks();
        $this->expectOutputRegex('/alpha1/');
    }
}
