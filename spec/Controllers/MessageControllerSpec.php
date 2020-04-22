<?php

namespace spec\App\Controllers;

use App\Controllers\Message;
use PhpSpec\ObjectBehavior;

class MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Message::class);
    }

    //new msg
    //remove msg
    //list
}
