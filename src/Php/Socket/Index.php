<?php

declare(strict_types = 1);

namespace Phpext\Php\Socket;

use Phpext\DisplayInterface;

class CustomError extends \AssertionError {}

class Index implements DisplayInterface
{
    public function call()
    {
        // @todo
    }

    /**
     * CLIENT
     * connect to server
     * write HEAD / HTTP/1.1\r\n
     * write messages\r\n...
     * write messages\r\n...
     * (ask server to close connection)
     * close
     */
    function simple_client()
    {
        //ok
        ini_set('assert.exception', 1);
        assert(false, new CustomError('Custom Error Message!'));
    }
}

