<?php

namespace Socket;

class Manager
{
    /**
     * SERVER
     * bind, listen...
     *  wait acceptation
     *   wait reading...
     *  close acceptation
     * close server
     */
    function it_test_server()
    {
        set_time_limit(0);
        ob_implicit_flush();
        
        echo PHP_EOL;
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); echo 's: create'.PHP_EOL;
        socket_bind($sock, '127.0.0.1', 1104); echo 's: bind'.PHP_EOL;
        socket_listen($sock, 5); echo 's: listen'.PHP_EOL;
        do { 
            $msgsock = socket_accept($sock); echo 's: accepted'.PHP_EOL;
            $msg = 's: hi'.PHP_EOL;
            socket_write($msgsock, $msg, strlen($msg));
        
            do {
                $buf = @socket_read($msgsock, 2048, PHP_NORMAL_READ); //echo 's: read "'.$buf.'"'.PHP_EOL;
                if (!$buf = trim($buf)) {
                    //echo 's: trim'.PHP_EOL; 
                    //continue;
                }
                if (trim($buf) == 'quit') {
                    echo 's: QUITTED'.PHP_EOL; 
                    break;
                }
                if (trim($buf) == 'shutdown') {
                    socket_close($msgsock);
                    echo 's: SHUTDW'.PHP_EOL; 
                    break 2;
                }
                echo "s: Write -received {$buf}- to client...".PHP_EOL;
                $talkback = "s: Serveur answer : received {$buf}".PHP_EOL;
                socket_write($msgsock, $talkback, strlen($talkback));
                
            } while (true);
            socket_close($msgsock);
        } while (true);
        socket_close($sock);
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
    function it_test_client()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); echo 'c: create'.PHP_EOL;
        $result = socket_connect($socket, '127.0.0.1', 1104); echo 'c: connect'.PHP_EOL;
        
           // $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); echo 'c: create'.PHP_EOL;
            echo 'c: write '.PHP_EOL;
           // $in = "HEAD / HTTP/1.1\r\nalpha\r\nquit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
            $in = "HEAD / HTTP/1.1\r\nalpha\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
            socket_write($socket, $in, strlen($in)); 
            /*while (@$out = socket_read($socket, 2048)) {
                echo 'c: read '.$out.PHP_EOL;
            }*/
        for($i=0;$i<2;$i++) :
            sleep(2);
            echo 'c: write2 '.PHP_EOL;
           // $in = "HEAD / HTTP/1.1\r\nalpha\r\nquit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
            $in = "alpha $i \r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
            socket_write($socket, $in, strlen($in)); 
            
        endfor;
        echo 'c: close '.PHP_EOL;
        // $in = "HEAD / HTTP/1.1\r\nalpha\r\nquit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
         $in = "quit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
         socket_write($socket, $in, strlen($in)); 
        socket_close($socket);
    }

}