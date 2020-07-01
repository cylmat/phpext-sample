<?php

declare(strict_types = 1);

namespace Socket;

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
    function client_native()
    {
        include 'simple_client.php';
        client_native();
    }
}

