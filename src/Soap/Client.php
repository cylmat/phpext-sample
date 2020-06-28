<?php

declare(strict_types=1);

namespace Soap;

class Client
{
    public function call($param)
    {
        $client = new \SoapClient(null, array(
            'location' => \Soap\ServerManager::URI,
            'uri'      => \Soap\ServerManager::URI,
            'trace'    => 1,
            "soap_version" => SOAP_1_2
         ));
        
        try {
            //$return = $client->__soapCall("getMessage", ["world"]);
            $return = $client->getMessage(implode(',', $param));
            echo($return);
        } catch (\SoapFault $f) {
            var_dump($f->getMessage());
            var_dump($client->__getLastResponse());
        }
    }
}
