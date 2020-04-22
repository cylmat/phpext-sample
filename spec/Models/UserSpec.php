<?php

namespace spec\App\Models;

use App\Models\User;
use PhpSpec\ObjectBehavior;
use App\Managers\RedisManager;

use App\Managers\SessionManager;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new RedisManager);
        
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
        //$this->flush();
    }

    function it_create()
    {
        $this->login = 'john9';
        $this->create()->shouldReturn(true);

        $this->getLastInsertId()->shouldBeInteger();
        $id = $this->getLastInsertId();

        $this->read($id)->shouldHaveKeyWithValue('login', 'john9');
        $this->read($id)->shouldBeArray();
    }

    function it_login()
    {
        $login = 'john9';
        $this->existsLogin($login)->shouldReturn(true);
    }

    function it_update()
    {
        $id = $this->getLastInsertId();
        $this->read($id);

        $this->login = 'john2';
        $this->update()->shouldReturn(true);
        $this->read($id)->shouldHaveKeyWithValue('login', 'john2');
    }

    function it_read_all()
    {
        $id = $this->getLastInsertId();
        $this->read($id);
        $this->readAll()->shouldBeArray();
        $this->readAll()->shouldHaveKey($this->login);
    }

    function it_can_follow() 
    {
        $id = $this->getLastInsertId();
        $this->read($id);
        
        $other_user_id = 9997;
        $this->follow($other_user_id)->shouldReturn(true);

        $this->get_followers()->shouldBeArray();
        $this->get_followers()->shouldHaveKeyWithValue(0, (string)$other_user_id);
        $this->unfollow($other_user_id)->shouldReturn(true);
        
    }

    function it_delete()
    {
        $id = $this->getLastInsertId();
        $this->read($id);

        $this->delete()->shouldReturn(true);
    }
    
}
