<?php

namespace Phpext\tests\Php;

use \PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2020-06-18 at 18:23:31.
 */
class IndexTest extends TestCase
{
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        //
    }



    /************************************classiques  */
    public function testExceptions()
    {
        Index::run();
        $this->expectOutputRegex('/FIN DU PROGRAMME/');
    }

}
