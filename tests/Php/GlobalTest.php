<?php

namespace Phpext\Tests\Php;

use Phpext\Php\Closures\Index as ClosuresIndex;
use Phpext\Php\GetText\Index as GetTextIndex;
use Phpext\DisplayableTestCase;

class GlobalTest extends DisplayableTestCase
{
    protected ClosuresIndex $closures;
    protected GetTextIndex $getText;

    protected function setUp(): void
    {
        $this->closures = new ClosuresIndex;
        $this->getText = new GetTextIndex;
    }

    public function tests()
    {
        $this->closures->call();
        $this->getText->call();
    }
}
