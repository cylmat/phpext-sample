<?php 

declare(strict_types = 1);

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
        $server = new \SoapServer(NULL, [
            'location' => \Soap\ServerManager::URI,  
            'uri' => \Soap\ServerManager::URI,  
            'soap_version' => SOAP_1_2
        ]);
        $server->setClass('\Soap\ServerManager'); 
        $server->handle();
    }
}