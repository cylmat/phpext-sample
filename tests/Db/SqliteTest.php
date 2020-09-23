<?php

namespace Db\Sqlite;

/**
 * Generated 
 */
class SqliteTest extends \PHPUnit\Framework\TestCase
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

    function testSqlite()
    {
        $this->index->index();
        $this->expectOutputRegex('/john/');
    }
}