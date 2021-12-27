<?php

declare(strict_types=1);

namespace Phpext\Php\Soap;

class Client
{
    private $client;

    public function create(): bool
    {
        try {
            $this->client = new \SoapClient(null, array(
                'location' => \Soap\ServerManager::$URI,
                'uri'      => \Soap\ServerManager::$URI,
                'trace'    => 1,
                "soap_version" => SOAP_1_2
            ));
            return true;
        } catch(\Exception $e) { 
            echo $e->getMessage(); 
        }
        return false;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function call(array $param)
    {
        try {
            //$return = $client->__soapCall("getMessage", ["world"]);
            echo $this->client->getMessage(implode(',', $param));
        } catch (\SoapFault $f) {
            var_dump($f->getMessage());
            var_dump($this->client->__getLastResponse());
        }
    }
}
