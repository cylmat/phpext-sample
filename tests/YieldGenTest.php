<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2020-06-18 at 18:23:31.
 */
class YieldGenTest extends \PHPUnit\Framework\TestCase
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
        $this->i = new \YieldGen\Index;
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
        //$this->assertEquals($this->manager->use_gen(), ['first:0','second:1','third:2']);
        //$this->assertEquals($this->manager->use_new_gen(), '0:1:2:3:4:5:6:7:8:9:');
    }

    public function testUseGen2() 
    {
        $this->i->yielding2();
        $this->expectOutputRegex('/0:1:2:3:4:5/');
        //$this->assertEquals($this->manager->use_gen(), ['first:0','second:1','third:2']);
        //$this->assertEquals($this->manager->use_new_gen(), '0:1:2:3:4:5:6:7:8:9:');
    }

    public function testTaskRunner() 
    {
        $this->i->tasks();
        $this->expectOutputRegex('/alpha1/');
        //$tasks = $this->taskRunner->run();
        //$this->assertTrue(true);
    }
}
