<?php

declare(strict_types = 1);

#NO NAMESPACE
#RUN FROM php -f script


define('SERVER_ADDRESS', '127.0.0.1'); 
define('SERVER_PORT', 4444);

set_time_limit(3000); #5mn

server_native();

/**
 * SERVER
 * bind, listen...
 *  wait acceptation
 *   wait reading...
 *  close acceptation
 * close server
 */
function server_native()
{
    ob_implicit_flush();
    
    echo PHP_EOL;
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('IMPOSSIBLE DE CREER LE SERVEUR'); 
    echo 'CREATE SERVER '.PHP_EOL;

    socket_bind($sock, SERVER_ADDRESS, SERVER_PORT) or die("IMPOSSIBLE DE SE CONNECTER AU SERVEUR"); 
    echo 'CONNECTED TO SERVER '.PHP_EOL;

    socket_listen($sock, 5); 
    echo 'LISTENING '.PHP_EOL;

    do { 
        $msgsock = socket_accept($sock); 
        echo 'CONNECTION ACCEPTED '.PHP_EOL;
        socket_set_nonblock ( $sock );

        $msg = 'HI! '.PHP_EOL;
        socket_write($msgsock, $msg, strlen($msg));
    
        do {
            $buf = socket_read($msgsock, 2048, PHP_NORMAL_READ); 
            echo 'READ "'.$buf.'"'.PHP_EOL;

            if (!$buf = trim($buf)) {
                echo 'TRIM '.PHP_EOL; 
                continue;
            }
            if (trim($buf) == 'quit') {
                echo 'QUITTED '.PHP_EOL; 
                break 2;
            }
            if (trim($buf) == 'shutdown') {
                socket_close($msgsock);
                echo 'SHUTDW '.PHP_EOL; 
                break 2;
            }
            echo "WRITE \"---S:Received {$buf}---\" TO CLIENT ".PHP_EOL;
            $talkback = "---S:Received {$buf}---";
            socket_write($msgsock, $talkback, strlen($talkback));
            
        } while (true);
        socket_close($msgsock);

    } while (true);
    socket_close($sock);
}