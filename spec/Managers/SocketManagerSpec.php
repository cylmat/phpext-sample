<?php

namespace spec\App\Managers;

use App\Managers\SocketManager;
use PhpSpec\ObjectBehavior;

class SocketManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SocketManager::class);
    }
}
