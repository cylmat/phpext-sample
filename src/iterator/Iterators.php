<?php

declare(strict_type=1);

namespace Iterator;

/*
 * 
https://www.php.net/manual/fr/spl.interfaces.php  
Countable -> fct count()
OuterIterator -> getInnerIterator()
RecursiveIterator -> getChildren(), hasChildren()
SeekableIterator -> seek(int pos) ... OutOfBounds

https://www.php.net/manual/fr/spl.iterators.php
AppendIterator
ArrayIterator -> permet de réinitialiser et de modifier les valeurs et les clés lors de l'itération de tableaux et d'objets
CachingIterator
CallbackFilterIterator
DirectoryIterator
EmptyIterator
FilesystemIterator
FilterIterator
GlobIterator
InfiniteIterator
IteratorIterator
LimitIterator
MultipleIterator
NoRewindIterator
ParentIterator
RecursiveArrayIterator
RecursiveCachingIterator
RecursiveCallbackFilterIterator
RecursiveDirectoryIterator
RecursiveFilterIterator
RecursiveIteratorIterator
RecursiveRegexIterator
RecursiveTreeIterator
La classe RegexIterator
 */
class Iterators
{
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