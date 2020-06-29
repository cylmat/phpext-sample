<?php

/*
 * This file is part of SocketManager.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 App\Managers 
 */
namespace App\Managers\Socket;
set_time_limit(0);

class SocketManager
{
    const SERVER_ADDRESS = '127.0.0.1';
    const SERVER_PORT = '1234';
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
            throw new \Exception($this->log);
            return false;
        }
        if(!@socket_bind($this->socket, self::SERVER_ADDRESS, self::SERVER_PORT)) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        }
        return true;
    }
    /*
     * socket_accept — Accepte une connexion sur un socket
     *  socket_accept ( resource $socket ) : resource
     * 
     *  Une fois que le socket socket a été créé avec la fonction socket_create(), lié à un nom avec la fonction socket_bind(), 
     * et mis en attente de connexion avec la fonction socket_listen(), socket_accept() va accepter les connexions sur ce socket. 
     * Une fois qu'une connexion est faite, une nouvelle ressource de socket est retournée. Elle peut être utilisée pour les communications. 
     * S'il y a plusieurs connexions en attente, la première sera utilisée. S'il n'y a pas de connexion en attente, socket_accept() 
     * se bloquera jusqu'à ce qu'une connexion se présente. Si socket a été rendue non-bloquante, grâce à socket_set_blocking() ou 
     * socket_set_nonblock(), FALSE sera retourné.
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
        if (($socket_listened = socket_accept($this->socket)) === false) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        } 
        echo 's: accept'.PHP_EOL;
        // Listen.
        while(true) {
            $buf = $this->read($socket_listened);
            echo 's: read "'.$buf.'"';
            
            if(!$buf) {
                echo 'server: nothing'.PHP_EOL;
            }
            if('exit' == $buf) {
                echo 'server: QUIT LISTENING'; echo 'nothing';
                break;
            }
            sleep(1);
        }
        return true;
    }
    public function createClient(): bool
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (false === $this->socket) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        }
        if (!socket_connect($this->socket, self::SERVER_ADDRESS, self::SERVER_PORT)) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        }
        return true;
    }
    /*public function listen(): bool
    {
        if(!$this->isValid()) {
            return false;
        }
        if(!socket_listen($this->socket)) {
            $this->logError($this->socket);
            throw new \Exception($this->log);
            return false;
        }
        return true;
    }*/
    public function close(): bool
    {
        // TODO: write logic here
        if (!$this->socket) {
            throw new \Exception("Socket doesn't exists");
            return false;
        }
        @socket_close($this->socket);
        $this->socket = null;
        return true;
    }
    private function logError($rh): void
    {
        $this->log .= socket_strerror( socket_last_error($rh) ); 
    }
    public function getLog(): string
    {
        return $this->log;
    }
    /**
     * socket_read — Lit des données d'un socket
     *  socket_read ( resource $socket , int $length [, int $type = PHP_BINARY_READ ] ) : string
     */
    public function read($socket_listened): ?string
    {
        // TODO: write logic here
        if (false === (@$msg = socket_read($socket_listened, 4096,  PHP_NORMAL_READ))) {
            //$this->logError($this->socket);
            //echo 'Error read'.PHP_EOL;
            //throw new \Exception($this->log);
            //return null;
        }
        return $msg;
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
        if (!$this->isValid()) {
            return false;
        }
        // TODO: write logic here
        if (!socket_write($this->socket, $msg, strlen($msg))) {
            $this->logError($this->socket);
            echo 'c: not writed'.PHP_EOL;
            throw new \Exception($this->log);
            return false;
        }
        return true;
    }
    public function isValid(): bool
    {
        // TODO: write logic here
        if(!$this->socket) {
            return false;
        }
        return true;
    }
}
