<?php declare(strict_types = 1);

namespace Iterator;

new Iterators;
new RecursiveIterators;

class Index
{
    public function index(){}


    public function array(array $array=['john','flush'])
    {
        $iter = new \ArrayIterator($array);
        $r=[];
        foreach ($iter as $content) {
            echo $content.'<br/>';
        }
    }

    public function directory()
    {
        $dir = new \DirectoryIterator(ROOT.'/src');
        foreach ($dir as $sub) {
           echo $dir->getFilename().'<br/>';
        }
    }

    public function iterIter()
    {
        $ii = new MyIterIter(new \ArrayIterator(['deli', 'satir', 'plus']));
        $ii->rewind();
        while ($ii->valid()) {
            $ii->next();
        }
    }

    public function aggregate()
    {
        $iterA = new MyIterAggregate;
        foreach ($iterA as $value) {
        // echo $value.'
        }
    }

    public function logFilter()
    {
        $ipFilter = new MyLogFilterIterator(new \ArrayIterator([10=>'10.21.510.6', 15=>'10.21.510.9', 25=>'110.21.510.2']));
        foreach ($ipFilter as $ip)
        {
            echo $ip.' ';
        }
    }


    /********************************************************************* */

/**
     * La classe RecursiveDirectoryIterator fournit un moyen d'itérer récursivement sur des dossiers d'un système de fichiers. 
     */
    public function recursiveDirectory()
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

    /**
     * IteratorIterator
     * Cet itérateur permet la conversion de n'importe quel objet Traversable en un itérateur
     */
    public function recursiveFiles()
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

    public function glob()
    {
        
        /*
        * Glob
        */ 
        /*
        * DirectoryIterator (path): 
        *  - SplFileInfo : isDot, isDir, getFilename, getPathname...
        *  - seek(), valid, next, rewind, current() : DirectoryIterator
        */
        $dirs = new \DirectoryIterator(__DIR__); 
        foreach ($dirs as $file) {
            //echo $file->getFilename().'
        }

        /*
        * FilesystemIterator (path, FLAG)
        *  - SplFileInfo
        *  - current(): DirectoryIterator(SplFileInfo)
        */
        $sys = new \FilesystemIterator(__DIR__);
        foreach ($sys as $path => $splinfo) {
            //echo $path.':'.$splinfo->getCTime().'<br/>';
        }
        $sys = new \FilesystemIterator(__DIR__, \FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::CURRENT_AS_PATHNAME);
        foreach ($sys as $file => $path) {
            // echo $file.':'.$path.'<br/>';
        }
        $sys = new \FilesystemIterator(__DIR__, \FilesystemIterator::CURRENT_AS_SELF);
        foreach ($sys as $path => $filesystem) {
            //echo $filesystem->getFilename().':'.$filesystem->getCTime().'';
        }

    } 
}


