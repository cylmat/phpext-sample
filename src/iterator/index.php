<?php declare(strict_types = 1);

namespace Iterator;

class Index
{
    /**
     * 
     */
    public function index()
    {
       // $this->recursiveFiles();
       echo 'ert';
    }

    /**
     * La classe DirectoryIterator fournit une interface simple pour lire le contenu d'un système de fichiers. 
     */
    public function directory()
    {
        $dir = new \DirectoryIterator(ROOT);
        foreach ($dir as $sub) {
            echo $dir->getFilename().'<br/>';
        }
    }

    /**
     * IteratorIterator
     * Cet itérateur permet la conversion de n'importe quel objet Traversable en un itérateur
     */
    public function iterator()
    {
        $iter = new \ArrayIterator(['john','flush']);
        
        foreach ($iter as $i) {
            //s($i);
        }
        
    }

    /**
     * La classe RecursiveDirectoryIterator fournit un moyen d'itérer récursivement sur des dossiers d'un système de fichiers. 
     */
    public function recursivedirectory()
    {
        $dirs = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(ROOT.'/src'));
        
        $dirs->rewind();
        while ($dirs->valid()) {
            // RecursiveIteratorIterator
            if (!$dirs->isDot()) {
                echo $dirs->getFilename().'<br/>';
            }
            $dirs->next();
        } 
    }

    public function recursivefiles()
    {
        $path = ROOT;
        $rdi = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::KEY_AS_PATHNAME);
        foreach ($rdi as $file => $info) {
            //echo $info->getFilename().'<br>';
        }
        $d = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($d as $file => $info) {
            //echo $info->getFilename()."<br/>";
        }
    }
}

