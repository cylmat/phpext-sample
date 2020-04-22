<?php

namespace spec\App\Models;

use App\Models\Message;
use PhpSpec\ObjectBehavior;
use App\Managers\RedisManager;

class MessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new RedisManager);   
        $this->user = 9999;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Message::class);
    }

    function it_create()
    {
        $msg = "writing...";
        $this->msg = $msg;
        $this->create()->shouldReturn(true);

        $id = $this->getLastInsertId();
        $this->read($id)->shouldHaveKeyWithValue(Message::MSG_TEXT, $msg);

        $this->msg = $msg.'deuxieme';
        $this->create()->shouldReturn(true);

        $this->getPostedMessages()->shouldBeArray();
        //var_dump( $this->getPostedMessages()->getWrappedObject() );
        //$this->getPostedMessages()->shouldBeArray(Message::MSG_TEXT, $msg.'deuxieme');
    }

    function it_can_be_add_to_followers()
    {
        $id = $this->getLastInsertId();
        $this->read($id);
        $this->insertToFollowersLists([25,34])->shouldReturn(true); 
    }

    function its_messages_can_be_listed_for_a_user()
    {
        $this->user = 25;
        $this->getMessagesList();
    }

    function it_delete()
    {
        $this->shouldThrow(\OutOfRangeException::class)->duringDelete();

        $id = $this->getLastInsertId();
        $this->read($id)->shouldNotReturn([]);
        $this->delete()->shouldReturn(true);

        $this->delete()->shouldReturn(false);
    }

    /*function it_can_be_remove_from_followers()
    {
        
    }*/
}
