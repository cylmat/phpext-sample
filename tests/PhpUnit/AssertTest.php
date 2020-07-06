<?php

namespace PU;

class AssertTest extends Custom\CustomTestCase
{
    public function setUp(): void
    {

    }

    public function testCustomConstraint()
    {
        $this->assertThatIsOk("it's ok", "Yes... it's ok....");
    }
}