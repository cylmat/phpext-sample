<?php

namespace spec\App\Controllers;

use App\Controllers\IndexController;
use PhpSpec\ObjectBehavior;

class IndexControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IndexController::class);
    }

    

    //call list users(ldap), messages(redis), sockets live
    //call button new user, new msg, open socket
}
