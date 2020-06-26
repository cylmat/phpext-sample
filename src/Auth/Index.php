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


    #https://fr.wikipedia.org/wiki/Authentification_HTTP
    #https://www.php.net/manual/fr/features.http-auth.php

 /**
     * ref: https://fr.wikipedia.org/wiki/Authentification_HTTP
     * https://www.sitepoint.com/understanding-http-digest-access-authentication/
     */
    public function digestAction(&$digestObject=null)
    {
        #session_start();
        $digest = $digestObject ? $digestObject : new Digest;

        $user = ['user' => 'mypass'];
        $header_401 = function()use($digest){
            $h = $digest->getDigestHeader();
            header($h);
            header('HTTP/1.1 401 Unauthorized', 401);
            unset($_SESSION);
            session_destroy();
        };
        //PHP_AUTH_DIGEST
        //"username="azerrty", realm="Soap", nonce="c29hcDVlZjViMTRmZTJlODExLjg3Mzg2OTAz", uri="/soap/server/digest", 
        //algorithm=MD5, response="32d5c7869b4a8096b7ed7b6db7f6091b", opaque="c740969b60b76f28afb8af7cb5e4c0de", 
        //qop=auth, nc=00000001, cnonce="949453b9e0c8bca6"" 
        if (!isset($_SERVER['PHP_AUTH_DIGEST']) ||
            (isset($_SESSION['delai']) && time() > $_SESSION['delai']+15)
            ) {
            $header_401();
            die('Veuillez vous authentifier');
        }
        $response_parts = $digest->digest_parse($_SERVER['PHP_AUTH_DIGEST']);

        $valid = $digest->digest_validate($user, $response_parts);
        if(!$valid) {
            $header_401();
            die('Mauvais nom d\'utilisateur ou mot de passe');
        }
        //set time decconection after 5 secondes
        $_SESSION['delai'] = isset($_SESSION['delai']) ? $_SESSION['delai'] : time();
       // var_dump('<pre>', $_SESSION['delai'], $_SERVER, '</pre>');  #PHP_MD5, PHP_SHA256
        echo 'digest ok';
    }
}
