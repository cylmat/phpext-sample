<?php 

declare(strict_types = 1);

namespace Auth;

class Index
{
    /**
     * 
     */
    public function index()
    {
        $this->authAction();
    }



        /**
     *          basic
     * ref: https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Basic_authentication_scheme
     * https://username:password@www.example.com/
     * 
     * WWW-Authenticate: <type> realm=<realm>
     * Proxy-Authenticate: <type> realm=<realm>
     * 
     * Authorization: <type> <credentials>
     * Proxy-Authorization: <type> <credentials>
     * 
     *          digest
     * Digest: <digest-algorithm>=<digest-value>,<digest-algorithm>=<digest-value>
     * ex: Digest: sha-256=X48E9qOokqqrvdts8nOJRJN3OWDUoyWxBf7kbu9DBPE=,unixsum=30637
     */
     /**
      * Si header  Authentication Required
      * url de nouveau appelée avec PHP_AUTH_USER, PHP_AUTH_PW et AUTH_TYPE
      */
    public function authAction()
    {
        //echo password_hash('pass', PASSWORD_DEFAULT);
        
        session_start();
        if (!isset($_SERVER['PHP_AUTH_USER']) || #pas authentifié
            ('user'!=$_SERVER['PHP_AUTH_USER'] || #wrong user & pass
                !password_verify($_SERVER['PHP_AUTH_PW'], '$2y$10$59GRA7AQ7Cc7FBjMohpRdeZ6TE3Il2C5q1L5.gU/RZrKQ56tpkK3K')) ||
            (isset($_SESSION['delai']) && time() > $_SESSION['delai']+10) #too much delay 10s
            ) {
               
            header('WWW-Authenticate: Basic realm="Auth');
            header('HTTP/1.1 401 Unauthorized', true, 401);
            unset($_SESSION);
            session_destroy();
            die('401');
        }
        //set time decconection after 5 secondes
        $_SESSION['delai'] = isset($_SESSION['delai']) ? $_SESSION['delai'] : time();
        
        //var_dump('<pre>', $_SERVER, '</pre>');  #PHP_MD5, PHP_SHA256
        echo 'auth ok';
    }
    
}
