<?php

declare(strict_types = 1);

namespace Socket;

class CustomError extends \AssertionError {}

class Index
{
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

