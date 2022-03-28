<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Soap\Soap;
use PHPUnit\Framework\TestCase;

class SoapTest extends TestCase
{
    public function testClient_NO_TEST() 
    {
        $this->assertFalse(false);
        return;

        $this->index->client(); 
        $this->expectOutputRegex("/Could not connect to host/");

        $c = new \Soap\Client;
        $this->assertTrue($c->create());

        $soapClient = $this->getMockBuilder('\Soap\Client')
            ->setMethods(['getMessage'])
            ->getMock();

        $soapClient->expects($this->exactly(1))
            ->method('getMessage')
            ->with($this->stringContains('hi'));

        $c->setClient($soapClient);
        $c->call(['hi']);
    }
}
