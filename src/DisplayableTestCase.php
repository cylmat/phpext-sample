<?php

namespace Phpext;

use PHPUnit\Framework\TestCase;

class DisplayableTestCase extends TestCase
{
    public function testCase()
    {
        // Only check if no error is raised
        isset($this->index) ? $this->index->call() : $this->assertTrue(true);
    }

    /**
     * @group display
     */
    public function testDisplay()
    {
        var_dump($this->index->call());
    }
}
