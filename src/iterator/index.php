<?php declare(strict_types = 1);

namespace Iterator;

class Index
{
    /**
     * 
     */
    public function index()
    {
        $this->directoryIterator();
        $this->iteratorIterator();

        return [
            'DirectoryIterator',
            'IteratorIterator'
        ];
    }

    /**
     * La classe DirectoryIterator fournit une interface simple pour lire le contenu d'un système de fichiers. 
     */
    public function directoryIterator()
    {
        $dir = new \DirectoryIterator(ROOT);
        foreach ($dir as $sub) {
            //echo $dir->getFilename().'<br/>';
        }
    }

    /**
     * Cet itérateur permet la conversion de n'importe quel objet Traversable en un itérateur
     */
    public function iteratorIterator()
    {
        $iter = new \ArrayIterator(['john','flush']);
        
        foreach ($iter as $i) {
            s($i);
        }
    }
}

