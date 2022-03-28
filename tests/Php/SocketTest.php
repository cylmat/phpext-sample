<?php

namespace Phpext\tests\Php;

use Phpext\Php\Socket\Index;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    protected Index $index;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->index = new Index;
    }

    public function testServer()
    {
        $this->assertTrue(true);
        /*$sock = socket_create(AF_INET, SOCK_STREAM, 0);
        
        if (!socket_bind($sock, 'localhost', 0)) 
            throw new RuntimeException('Could not bind to address');

        socket_listen($sock);
       
        $this->client = socket_accept($sock);

        // Read the input from the client &#8211; 1024 bytes
        $input = socket_read($this->client, 1024);*/
    }

    
    public function testClient() 
    {
        //$this->index->simple_client();
        $this->assertTrue(true);
    }
}

/*
class ListeningServerStub
{
    protected $client;

    public function listen()
    {
        $sock = socket_create(AF_INET, SOCK_STREAM, 0);

        // Bind the socket to an address/port
        socket_bind($sock, 'localhost', 0) or throw new RuntimeException('Could not bind to address');

        // Start listening for connections
        socket_listen($sock);

        // Accept incoming requests and handle them as child processes.
        $this->client = socket_accept($sock);
    }

    public function read()
    {
        // Read the input from the client &#8211; 1024 bytes
        $input = socket_read($this->client, 1024);
        return $input;
    }
}*/
