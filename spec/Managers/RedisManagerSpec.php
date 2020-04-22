<?php

namespace spec\App\Managers;

use App\Managers\RedisManager;
use PhpSpec\ObjectBehavior;

class RedisManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RedisManager::class);
    }

    //read redis
    //list all values
    //create new one
    //remove value
    
    //add to fifo (messages)
    //remove from fifo
}
