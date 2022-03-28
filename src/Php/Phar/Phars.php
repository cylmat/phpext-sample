<?php

namespace Phpext\Php\Phar;

use Phpext\AbstractCallable;

class Phars extends AbstractCallable
{
    public const EXT = 'phar';
    private $mydata = [];

    function __construct(array $mydata=[])
    {
        $this->mydata = $mydata;
    }

    public function call(): array
    {
        $this->verify();

        return [];
    }

    public function add(array $val)
    {
        $this->mydata = array_merge($this->mydata, $val);
    }

    public function get()
    {
        return $this->mydata;
    }

    public function addhandled()
    {
        $this->mydata = array_merge($this->mydata, Input::handle());
    }

    public function dump()
    {
        var_dump($this->get());
    }
}
// sed -e -i 's/phar.readonly = On/phar.readonly = Off/' /etc/php/7.4/cli/php.ini 
