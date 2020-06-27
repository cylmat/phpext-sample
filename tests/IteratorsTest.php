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
        $this->i = new \Iterator\Index;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }



    /************************************classiques  */
    public function testArrays()
    {
        $this->i->arrays(['michel','flush']);
        $this->expectOutputRegex('/michel/');
    }

    
    public function testAggregate()
    {
        $this->i->aggregate();
        $this->expectOutputRegex('/012340/');
    }

    public function testIterIter()
    {
        $this->i->iterIter();
        $this->expectOutputRegex('/deliplussatirplus/');
    }

    public function testFilesystem()
    {
        $this->i->filesystem();
        $this->expectOutputRegex('/Iterator\/Index.php/');
    }

    /**
     * @covers Iterator\Index::directory
     * @todo   Implement testDirectory().
     */
    public function testDirectory()
    {
        $this->i->directory();
        $this->expectOutputRegex('/Iterator/');
    }

    public function testLogFilter()
    {
        $this->i->logFilter();
        $this->expectOutputRegex('/10.21.510.6 10.21.510.9 /');
    }

    





    /******************************recursives */
    public function testRecursiveArray()
    {
        $this->i->recursiveArray();
        $this->expectOutputRegex('/912354/');
    }

    public function testRecursiveDirectory()
    {
        $this->i->recursiveDirectory();
        $this->expectOutputRegex('/MyIterator.php/');
    }

    public function testRecursiveDirectory_iterators()
    {
        $this->i->recursiveDirectory_iterators();
        $this->expectOutputRegex('/MyIterator.php/');
        $this->expectOutputRegex('/[^notvalid]/');
    }

    public function testrecursiveIterator()
    {
        $this->i->recursiveIterator();
        $this->expectOutputRegex('/0-1-2-0-1-2-3-4-5-6-4-5-6-/');
    }

    public function testRecursiveFiles()
    {
        $this->i->recursiveFiles();
        $this->expectOutputRegex('/MyIterator.php/');
    }

    public function testRecursiveRegex()
    {
        $this->i->recursiveRegex();
        $this->expectOutputRegex('/.php/');
    }

    public function testRecursiveTree()
    {
        $this->i->recursiveTree();
        $this->expectOutputRegex('/\|-912354\|/');
    }
    
}
