<?php

namespace spec\App\Managers;

use App\Managers\SessionManager;
use App\Managers\RedisManager;
use PhpSpec\ObjectBehavior;

class SessionManagerSpec extends ObjectBehavior
{
    function let()
    {
        $id_test = 9999;
        $this->beConstructedWith(new RedisManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SessionManager::class);
    }

    function it_start()
    {
        $id_test = 9999;
        $this->start(9999)->shouldBeString();
        $hash = $this->start(9999)->getWrappedObject();
        
        $_COOKIE['SESSIONIDREDIS']=$hash;
    }

    function its_valid()
    {
        $this->isValid()->shouldReturn(true);
    }

    function it_set()
    {
        $this->set('valuetest', '45');
    }

    function it_get()
    {
        $this->get('valuetest')->shouldReturn('45');
    }
    
    function it_close()
    {
        $this->close()->shouldReturn(true);
        
    }
}
