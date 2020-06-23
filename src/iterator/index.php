<?php declare(strict_types = 1);

namespace Iterator;

class Index
{
    private $i, $r;

    function __construct()
    {
        $this->i = new Iterators;
        $this->r = new RecursiveIterators;
    }

    /**
     * 
     */
    public function index()
    {   
        
    }

    public function directory()
    {   
        $this->i->directoryIterator();
    }
}

