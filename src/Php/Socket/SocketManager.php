<?php

declare(strict_types = 1);

namespace Socket;

class SocketManager
{
    const SERVER_ADDRESS = '127.0.0.1';
    const SERVER_PORT = 1234;

    /**
     * resource
     */
    private $socket; 

    /**
     * string
     */
    private $log=''; 

    public function getConnection()
    {
        return $this->socket;
    }

    public function getLog(): string
    {
        return $this->log;
    }

    public function isValid(): bool
    {
        if (!$this->socket) {
            return false;
        }
        return true;
    }

    /**
     * RUN
     */
    public function runServer()
    {
        $this->createServer();
        $this->serverListen();
    }


    /**
     * socket_create — Crée un socket
     *  socket_create ( int $domain , int $type , int $protocol ) : resource
     * 
     * socket_bind — Lie un nom à un socket
     *  socket_bind ( resource $socket , string $address [, int $port = 0 ] ) : bool
     * 
     * socket_listen — Attend une connexion sur un socket
     *  socket_listen ( resource $socket [, int $backlog = 0 ] ) : bool
     *  
     * -
     * 
     * socket_create — Crée un socket
     * 
     * socket_connect — Crée une connexion sur un socket
     *  socket_connect ( resource $socket , string $address [, int $port = 0 ] ) : bool
     * 
     */
    public function createServer(): bool
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (false === $this->socket) {
            $this->logError($this->socket);
            return false;
        }
        if(!socket_bind($this->socket, self::SERVER_ADDRESS, self::SERVER_PORT)) {
            $this->logError($this->socket);
            return false;
        }
        echo 's: yes connected!'.PHP_EOL;
        return true;
    }

    /*
     * socket_accept — Accepte une connexion sur un socket
     *  socket_accept ( resource $socket ) : resource
     * 
     *  Une fois que le socket a été créé avec la fonction socket_create(), lié à un nom avec la fonction socket_bind(), 
     * et mis en attente de connexion avec la fonction socket_listen(), socket_accept() va accepter les connexions sur ce socket. 
     * Une fois qu'une connexion est faite, une nouvelle ressource de socket est retournée. Elle peut être utilisée pour les communications. 
     * S'il y a plusieurs connexions en attente, la première sera utilisée. S'il n'y a pas de connexion en attente, socket_accept() 
     * se bloquera jusqu'à ce qu'une connexion se présente. Si socket a été rendue non-bloquante, grâce à socket_set_blocking() ou 
     * socket_set_nonblock(), FALSE sera retourné.
     * 
    * La ressource de socket retournée par socket_accept() ne doit pas être utilisée pour accepter de nouvelles connexions. 
    * Le socket original socket, qui est en attente, reste ouvert et peut être réutilisé. 
     */
    public function serverListen(): bool
    {
        if (!socket_listen($this->socket)) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        }
        echo 's: listen'.PHP_EOL;
        
        // Listen.
        while(true) {
            if (($socket_accept = socket_accept($this->socket)) === false) {
                $this->logError($this->socket);
                throw new \Exception($this->log);
                return false;
            } 
            echo 's: accept'.PHP_EOL;
            while(true) {
                $buf = $this->read($socket_accept);
                echo 's: read "'.$buf.'" '.PHP_EOL;
                
                if(!$buf) {
                    echo 'server: nothing'.PHP_EOL;
                }
                if('quit' == $buf) {
                    echo 's: QUIT LISTENING'.PHP_EOL;
                    break;
                }
            }
            echo 's: closing acceptation';
            socket_close($socket_accept);
        }
        return true;
    }

    public function createClient(): bool
    {
        echo PHP_EOL;
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (false === $this->socket) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            echo 'c: not created!'.PHP_EOL;
            return false;
        }
        if (!socket_connect($this->socket, self::SERVER_ADDRESS, self::SERVER_PORT)) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            echo 'c: not connected!'.PHP_EOL;
            return false;
        }
        echo 'c: connected!'.PHP_EOL;
        return true;
    }

    /**
     * socket_read — Lit des données d'un socket
     *  socket_read ( resource $socket , int $length [, int $type = PHP_BINARY_READ ] ) : string
     */
    public function read($socket_listened): ?string
    {
        // TODO: write logic here
        echo 'Read..'.PHP_EOL;
        if (false === (@$msg = socket_read($socket_listened, 4096,  PHP_NORMAL_READ))) {
            //$this->logError($this->socket);
            //echo 'Error read'.PHP_EOL;
            //return null;
        }
        return trim($msg);
    }

    /**
     * socket_send — Envoie des données à un socket connecté
     *  socket_send ( resource $socket , string $buf , int $len , int $flags ) : int
     * 
     * socket_sendmsg — Envoi un message
     *  socket_sendmsg ( resource $socket , array $message [, int $flags = 0 ] ) : int
     * 
     *  socket_write ( resource $socket , string $buffer [, int $length = 0 ] ) : int
     * 
     * Une fois que le socket socket a été créé avec la fonction socket_create(), 
     * lié à un nom avec la fonction socket_bind(), et mis en attente de connexion avec la fonction socket_listen(), 
     * socket_accept() va accepter les connexions sur ce socket.
     * 
     *  Une fois qu'une connexion est faite, une nouvelle ressource de socket est retournée. 
     * Elle peut être utilisée pour les communications. S'il y a plusieurs connexions en attente, 
     * la première sera utilisée. S'il n'y a pas de connexion en attente, socket_accept() 
     * se bloquera jusqu'à ce qu'une connexion se présente. Si socket a été rendue non-bloquante, grâce à socket_set_blocking() 
     * ou socket_set_nonblock(), FALSE sera retourné. 
     */
    public function write(string $msg): bool
    {
        echo 'Write..'.PHP_EOL;
        if (!$this->isValid()) {
            echo 'not write valid'.PHP_EOL;
            return false;
        }
        
        if (!@socket_write($this->socket, $msg, strlen($msg))) {
            $this->logError($this->socket);
            echo 'not writed'.PHP_EOL;
            //return false;
        }
        echo 'writing '.$msg.PHP_EOL;
        return true;
    }

    public function close(): bool
    {
        if (!$this->socket) {
            $this->logError("Socket doesn't exists");
            return false;
        }
        @socket_close($this->socket);
        $this->socket = null;
        return true;
    }

    protected function logError($rh): void
    {
        if (is_string($rh)) {
            $this->log = $rh;
        } else {
            $this->log = socket_strerror( socket_last_error($rh) );
        }
        //throw new \Exception($this->log);
        echo $this->log.PHP_EOL; 
    }
}