<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2020-06-18 at 18:23:31.
 */
class IteratorsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Index
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->i = new \Iterator\Iterators;
        $this->r = new \Iterator\RecursiveIterators;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers Iterator\Index::directory
     * @todo   Implement testDirectory().
     */
    public function testDirectory()
    {
        $this->i->arrayIterator(['michel','flush']);
        $this->expectOutputString('michelflush');
    }

}
