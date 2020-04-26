<?php

namespace Iterator;

class Index
{
    /**
     * 
     */
    public function index()
    {
        $this->directory();
        $this->iteratoriterator();

        return [
            'DirectoryIterator',
            'IteratorIterator'
        ];
    }

    public function directory()
    {
        $dir = new \DirectoryIterator(ROOT);
        foreach($dir as $sub) {
            //echo $dir->getFilename().'<br/>';
        }
    }

    public function iteratoriterator()
    {
        $dir = new \DirectoryIterator(ROOT);
        foreach($dir as $sub) {
            //echo $dir->getFilename().'<br/>';
        }
    }
}

