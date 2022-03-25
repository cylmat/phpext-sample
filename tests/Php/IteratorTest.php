<?php

namespace Phpext\tests\Php;

use Phpext\Php\Iterators\Index;
use PHPUnit\Framework\TestCase;

class IteratorsTest extends TestCase
{
    protected Index $object;

    protected function setUp(): void
    {
        $this->i = new Index;
    }

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
        $this->expectOutputRegex('/Index\.php/');
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

    public function testRecursiveDirectoryIterators()
    {
        $this->i->recursiveDirectoryIterators();
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
