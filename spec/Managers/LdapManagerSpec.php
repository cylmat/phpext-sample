<?php

namespace spec\App\Managers;

use App\Managers\LdapManager;
use PhpSpec\ObjectBehavior;

class LdapManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LdapManager::class);
    }

    /*function it_calls_ldap_on_index(\App\Managers\LdapManager $ldap)
    {
        $ldap->connect()->shouldBeCalledTimes(1);
        $this->indexAction($ldap);
    }*/

    //open connection
    //close connection
    //add new 
    //read one
    //read list all
    //remove one
}
