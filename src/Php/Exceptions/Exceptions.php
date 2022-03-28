<?php

declare(strict_types=1);

namespace Phpext\Php\Exceptions;

use Phpext\AbstractCallable;

class Exceptions extends AbstractCallable
{
    private static $e;

    const CONFIG = [
        'dev' => true,
        // 'ex_handle' => true,
        // 'err_handle' => true
    ];

    public function call(): array
    {
        return [
            self::run(),
            self::process(),
        ];
    }

    static function run()
    {
        if (self::CONFIG['dev']) 
            self::$e = new Dev; 
        else 
            self::$e = new Prod;
        //self::$e->setShutdown();
        self::process();
    }

    static function process()
    {
        try {
            self::$e->throwException();
        } catch (\Exception $e) {
            echo 'Exception attrapée par try/catch<br/>';
        }

        //php
        //self::$e->throwWarning();
        //self::$e->triggerError(1); #warning

        //SET
        // self::$e->setErrorHandler();
        // self::$e->setExceptionHandler();
        //self::$e->throwError();

        //self::$e->throwMyException();
        /*self::$e->triggerError(2); #error
        self::$e->throwError();*/

        echo 'FIN DU PROGRAMME';
    }
}

class MyException extends \RunTimeException
{
    public function __construct($message, $code = 0)
    {
        $message = "MyException message: " . $message;
        parent::__construct($message, 9999);
    }
    
    public function __toString()
    {
        return $this->message . '__toString';
    }
}

abstract class ExceptionError
{
    function setExceptionHandler()
    {
        set_exception_handler(function($exception) {
            echo 'My exception: (Code '.$exception->getCode() . '): '.$exception->getMessage().'<br/>';
        });
    }

    function setErrorHandler()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            /*if (!(error_reporting() & $errno)) {
                // Ce code d'erreur n'est pas inclus dans error_reporting(), donc il continue
                // jusqu'au gestionaire d'erreur standard de PHP
                return;
            }*/
            echo 'Une erreur fut lancée';
            switch($errno) {
                case 1: $str = 'E_ERROR'; break;
                case 2: $str = 'E_WARNING'; break;
                case 8: $str = 'E_NOTICE'; break;
                case 256: $str = 'E_USER_ERROR'; break;
                case 512: $str = 'E_USER_WARNING'; break;
                case 1024: $str = 'E_USER_NOTICE'; break;
                case 4096: $str = 'E_RECOVERABLE_ERROR'; break;
                case 8192: $str = 'E_DEPRECATED '; break;
                case 16384: $str = 'E_USER_DEPRECATED '; break;
                default: $str='-E-';
            }
        
            echo 'My error handler: (Code '.$errno . '-'.$str.'): '.$errstr.'<br/>';
        }, E_ALL);
    }

    /**
     * Display nice error page when in PROD
     */
    function setShutdown()
    {
        register_shutdown_function(function () {
            $error = error_get_last();
            if($error){
                //throw new ErrorException($error['message'], -1, $error['type'], $error['file'], $error['line']);
            }
            echo 'My shutted down : set HTTP 500';
        });
    }

    function restore()
    {
        restore_exception_handler();
        restore_error_handler();
    }

    #Fatal error : Uncaught Exception
    function throwException()
    {
        throw new \Exception("\Exception lancée");
    }

    function throwMyException()
    {
        throw new MyException("MyException lancée");
    }

    function triggerError(int $type)
    {
        switch ($type) {
            case 0: trigger_error('Notice E_USER lancée: ', E_USER_NOTICE); break;
            case 1: trigger_error('Warning E_USER lancée: ', E_USER_WARNING); break;
            case 2: trigger_error('Erreur E_USER lancée: ', E_USER_ERROR); break;
            case 3: trigger_error('Déprécié E_USER lancée: ', E_USER_DEPRECATED); break;
        }
    }

    #Fatal error : Uncaught Error Class 'r' not found
    function throwError()
    {
        new r;
    }

    #Warning: Division by zero 
    function throwWarning()
    {
        10/0;
    }

    #Notice: Undefined variable: t 
    function throwNotice()
    {
        $t .= '';
    }
}

class Dev extends ExceptionError
{
    function __construct()
    {
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);
    }
}

class Prod extends ExceptionError
{
    function __construct()
    {
        ini_set('display_errors', 'off');
        error_reporting(0);
    }
}