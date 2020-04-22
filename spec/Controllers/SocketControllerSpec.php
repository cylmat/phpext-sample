<?php

namespace spec\App\Controllers;

use App\Controllers\SocketController;
use PhpSpec\ObjectBehavior;

class SocketControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SocketController::class);
    }

    //open socket
    //close socket
    //list opened
}
