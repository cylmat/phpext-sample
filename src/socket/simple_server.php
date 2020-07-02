<?php

declare(strict_types = 1);

#NO NAMESPACE
#RUN FROM php -f script


define('SERVER_ADDRESS', '127.0.0.1'); 
define('SERVER_PORT', 4444);

set_time_limit(3000); #5mn

//toute fonction qui envoie des données au navigateur verra ses données envoyées immédiatement
ob_implicit_flush(); 

//only from CLI
echo PHP_EOL;
simple_server();

/**
 * SERVER
 * bind, listen...
 *  wait acceptation
 *   wait reading...
 *  close acceptation
 * close server
 */
function simple_server()
{   
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('IMPOSSIBLE DE CREER LE SERVEUR'); 
    echo "CREATE SERVER ".PHP_EOL;

    socket_bind($socket, SERVER_ADDRESS, SERVER_PORT) or die("IMPOSSIBLE DE SE CONNECTER AU SERVEUR"); 
    echo 'CONNECTED TO SERVER '.PHP_EOL;

    socket_listen($socket, 5); 
    echo 'LISTENING '.PHP_EOL;

    $print_to_socket = function($socket, string $msg) {
        $msg = $msg . ' ' . PHP_EOL;
        socket_write($socket, $msg, strlen($msg));
    };

    $read_from_socket = function($socket) {
        $buf = trim(socket_read($socket, 2048, PHP_NORMAL_READ)); 
        echo 'READ "' . $buf . '"' . PHP_EOL;
        return $buf; 
    };

    // Wait for client
    do { 
        $msgsock = socket_accept($socket); 
        echo 'CONNECTION ACCEPTED '.PHP_EOL;
        socket_set_block ( $socket ); //wait for other clients

        $print_to_socket($msgsock, "Hi!");
    
        // Listen to read data
        do {
            $buffer = $read_from_socket($msgsock);

            if (!$buffer) {
                continue;
            }
            if ($buffer == 'quit') {
                echo 'QUITTED '.PHP_EOL; 
                socket_close($msgsock); //close acceptation
                break;
            }
            if ($buffer == 'shutdown') {
                echo 'SHUTDW '.PHP_EOL; 
                socket_close($msgsock); //close acceptation
                break 2;
            }
            $talkback = "---S:Received {$buffer}---";
            $print_to_socket($msgsock, $talkback);
            
        } while (true);

    } while (true);
    socket_close($socket); //totally close socket
}