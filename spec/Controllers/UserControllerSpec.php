<?php

namespace spec\App\Controllers;

use App\Controllers\UserController;
use PhpSpec\ObjectBehavior;

class UserControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserController::class);
    }

    //create on ldap
    //read list
    //remove ldap
}
