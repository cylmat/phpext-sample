<?php

declare(strict_types=1);

namespace Soap;

class Client
{
    public function call(array $param)
    {
        $client = new \SoapClient(null, array(
            'location' => \Soap\ServerManager::$URI,
            'uri'      => \Soap\ServerManager::$URI,
            'trace'    => 1,
            "soap_version" => SOAP_1_2
         ));
        
        try {
            //$return = $client->__soapCall("getMessage", ["world"]);
            echo $client->getMessage(implode(',', $param));
        } catch (\SoapFault $f) {
            var_dump($f->getMessage());
            var_dump($client->__getLastResponse());
        }
    }
}
