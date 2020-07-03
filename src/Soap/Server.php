<?php

declare(strict_types=1);

namespace Soap;

/**
 * ref: http://www.w3.org/2001/12/soap-envelope
 *      http://www.w3.org/2001/12/soap-encoding
 *
 * SOAP
 *  Envelope
 *  Header
 *  Body
 *  (Fault)
 */

class Server
{
    public function handle()
    {
        try { 
            $server = new \SoapServer(null, [
                'location' => \Soap\ServerManager::$URI,
                'uri' => \Soap\ServerManager::$URI,
                'soap_version' => SOAP_1_1
            ]);
        } catch(\SOAPFault $f) { 
            echo $f->getMessage();
        } catch (\Exception $e) { 
            echo $e->getMessage(); 
        }
        
        header("Content-Type: text/xml");
        $server->setClass('\Soap\ServerManager');
        $server->handle();
    }
}
