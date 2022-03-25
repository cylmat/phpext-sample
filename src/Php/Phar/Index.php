<?php

namespace Phpext\Php\Phar;

use Phpext\CallableInterface;
use Phpext\ExtensionVerifyTrait;

class Index implements CallableInterface
{
    use ExtensionVerifyTrait;

    private $mydata = [];

    function __construct(array $mydata=[])
    {
        $this->mydata = $mydata;
    }

    public function call(): array
    {
        $this->verify('phar');

        return [];
    }

    function add(array $val)
    {
        $this->mydata = array_merge($this->mydata, $val);
    }

    function get()
    {
        return $this->mydata;
    }

    function addhandled()
    {
        $this->mydata = array_merge($this->mydata, Input::handle());
    }

    function dump()
    {
        var_dump($this->get());
    }
}
// sed -e -i 's/phar.readonly = On/phar.readonly = Off/' /etc/php/7.4/cli/php.ini 