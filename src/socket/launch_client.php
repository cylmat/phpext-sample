<?php

declare(strict_types = 1);

#NO NAMESPACE
#RUN FROM include()



define('SERVER_ADDRESS', '127.0.0.1'); 
define('SERVER_PORT', 4444);

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
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Impossible de creer le socket"); 
    echo 'Create client..'.PHP_EOL;

    $result = socket_connect($socket, SERVER_ADDRESS, SERVER_PORT) or die("Unable to connect"); 
    echo 'Connect to socket..'.PHP_EOL;
    
    echo 'Writing "alpha"..'.PHP_EOL;

    $in = "HEAD / HTTP/1.1\r\nalpha\r\n"; 
    // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
    socket_write($socket, $in, strlen($in)); 

    $time = time();
    while ($out = socket_read($socket, 4096)) {
        echo 'Read.. '.$out.PHP_EOL;
        if (time() > $time+5) {
            echo 'Timeout.. ';
            break; //max 5s
        }
    }

    for($i=0; $i<2; $i++) {
        sleep(2);
        echo 'Writing "beta '.$i.'".. '.PHP_EOL;
        // $in = "HEAD / HTTP/1.1\r\nalpha\r\nquit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
        $in = "beta $i \r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
        socket_write($socket, $in, strlen($in)); 
    }

    echo 'Close connection..'.PHP_EOL;
    // $in = "HEAD / HTTP/1.1\r\nalpha\r\nquit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 

    $in = "quit\r\n"; // ."Host: 127.0.0.1\r\n" // ."Connection: Close\r\n" 
    socket_write($socket, $in, strlen($in)); 

    socket_close($socket);
}




/*
 *

https://stephaneey.developpez.com/tutoriel/php/sockets/

error_reporting(E_ALL);

echo "<h2>Connexion TCP/IP</h2>\n";

/* Lit le port du service WWW. *
$service_port = getservbyname('www', 'tcp');

/* Lit l'adresse IP du serveur de destination *
$address = gethostbyname('www.example.com');

/* Crée un socket TCP/IP. *
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() a échoué : raison :  " . socket_strerror(socket_last_error()) . "\n";
} else {
    echo "OK.\n";
}

echo "Essai de connexion à '$address' sur le port '$service_port'...";
$result = socket_connect($socket, $address, $service_port);
if ($socket === false) {
    echo "socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
} else {
    echo "OK.\n";
}

$in = "HEAD / HTTP/1.0\r\n\r\n";
$in .= "Host: www.example.com\r\n";
$in .= "Connection: Close\r\n\r\n";
$out = '';

echo "Envoi de la requête HTTP HEAD...";
socket_write($socket, $in, strlen($in));
echo "OK.\n";

echo "Lire la réponse : \n\n";
while ($out = socket_read($socket, 2048)) {
    echo $out;
}

echo "Fermeture du socket...";
socket_close($socket);
echo "OK.\n\n";
*/