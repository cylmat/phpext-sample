<?php

declare(strict_types = 1);

#NO NAMESPACE
#RUN FROM include()

defined('SERVER_ADDRESS') or define('SERVER_ADDRESS', '127.0.0.1'); 
defined('SERVER_PORT') or define('SERVER_PORT', 4444);

set_error_handler(function(int $errno, string $errstr, string $errfile, int $errline, array $errcontext) { 
    switch($errno) {
        case E_WARNING: echo 'WARNING: ' . $errstr . PHP_EOL;
    }
});

if (!isset($_SERVER['HTTP_HOST'])) {
    simple_client();
    simple_client(true);
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


function simple_client($last_client=false) 
{
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
    if ($socket === false) {
        echo "socket_create() a échoué: " . socket_strerror(socket_last_error()) . "\n";
        die("Impossible de creer le socket");
    } else {
        echo 'Create client..'.PHP_EOL;
    }

    socket_connect($socket, SERVER_ADDRESS, SERVER_PORT); 
    if ($socket === false) {
        echo "socket_connect() a échoué: " . socket_strerror(socket_last_error($socket)) . "\n";
        die("Unable to connect");
    } else {
        echo 'Connect to socket..'.PHP_EOL;
    }

    // Print to server
    $print_to_socket = function(string $data) use (&$socket) {
        echo 'Write: "'.$data.'"..'.PHP_EOL;
        $data .= "\r\n";
        socket_write($socket, $data, strlen($data)); 
    };

    //read
    $read_from_socket = function() use (&$socket) {
        $out = socket_read($socket, 2048);
        echo 'Read: "' . $out . '"..' . PHP_EOL;
    };
   
    $print_to_socket("HEAD / HTTP/1.1"); //first call

    // print then listen to socket
    $print_to_socket("alpha");
    $read_from_socket();

    for($i=0; $i<2; $i++) {
        sleep(2);
        $print_to_socket("beta $i");
        $read_from_socket();
    }

    echo 'Closing connection..'.PHP_EOL;

    if($last_client) {
        $print_to_socket("shutdown");
    } else {
        $print_to_socket("quit");
    }

    //close
    socket_close($socket);
}

