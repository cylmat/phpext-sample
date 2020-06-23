<?php

declare(strict_types=1);

namespace Iterator;

/*
    https://www.php.net/manual/fr/spl.iterators.php
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
class RecursiveIterators
{
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

    /**
     * IteratorIterator
     * Cet itérateur permet la conversion de n'importe quel objet Traversable en un itérateur
     */
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




/*
 *
 * test itération sur les fichiers logs
 *
 /*
  *  iterator_apply ( Traversable $iterator , callable $function [, array $args = NULL ] ) : int
  *  iterator_count ( Traversable $iterator ) : int
  *  iterator_to_array ( Traversable $iterator [, bool $use_keys = TRUE ] ) : array
  */
if(!isset($_GET['log'])) return;

/*
 * Glob
 */
/*
 * DirectoryIterator (path): 
 *  - SplFileInfo : isDot, isDir, getFilename, getPathname...
 *  - seek(), valid, next, rewind, current() : DirectoryIterator
 *
$dirs = new DirectoryIterator(__DIR__); 
foreach ($dirs as $file) {
    //echo $file->getFilename().'
';
}
/*
 * FilesystemIterator (path, FLAG)
 *  - SplFileInfo
 *  - current(): DirectoryIterator(SplFileInfo)
*
$sys = new FilesystemIterator(__DIR__);
foreach ($sys as $path => $splinfo) {
    //echo $path.':'.$splinfo->getCTime().'<br/>';
}
$sys = new FilesystemIterator(__DIR__, FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::CURRENT_AS_PATHNAME);
foreach ($sys as $file => $path) {
   // echo $file.':'.$path.'<br/>';
}
$sys = new FilesystemIterator(__DIR__, FilesystemIterator::CURRENT_AS_SELF);
foreach ($sys as $path => $filesystem) {
   //echo $filesystem->getFilename().':'.$filesystem->getCTime().'
';
}



                                            /********* Recursive **************
/*
 ALL recursive implements RecursiveIterator
 Only RecursiveIteratorIterator and TreeIterator implements OuterIterator !
*/


/*
 * RecursiveArrayIterator
 *  ArrayIterator::__construct ([ mixed $array = array() [, int $flags = 0 ]] ) 
 * 
 * 
 *  if find a getChildren, call it
 * 
$arr = [5789,56234,55654,5353,5326,5998,597865];
$arr2 = [94635,912354,9766,975,9654,95659,98646];
$arr23 = [94635,912354,9766,$arr,9654,95659,98646];
$iter = new ArrayIterator($arr);
$iter2 = new ArrayIterator($arr2);
new RecursiveArrayIterator(new DirectoryIterator(__DIR__)); #do nothing!
$iter_r = new RecursiveArrayIterator([5789,56234,55654,5353,5326,5998,597865]); #OK
$iter_arr = new RecursiveArrayIterator([5789,56234,$arr23,5353,5326,$arr,597865]); #OK
$iter_r1 = new RecursiveArrayIterator([2862,$iter2,287698,28753,$iter,27898,28978]); #no childrens
$iter_r2 = new RecursiveArrayIterator([865546,84456,8655436,811364,$iter_r1,8546,8654678]);
#exemple ERROR
#not infinity recursion
$iter_r->rewind();
while ($iter_r->valid()) {
    //echo $iter_a->current().'<br/>'; #ERROR, convert iterator to string!
    $iter_r->next();
}
// INFINITY
class DeepRecursiveArrayIterator implements Iterator
{
    protected $parent=null;
    protected $iterator=null;
    public function __construct(array $iterator)
    {
        $this->iterator = new RecursiveArrayIterator($iterator);
    }
    public function current()
    {
        if ($this->iterator->hasChildren()) { 
            $this->parent = $this->iterator;
            $this->iterator = $this->iterator->getChildren();
        }
        return $this->iterator->current();
    }
    public function valid()
    {
        if (!$this->iterator->valid() && null===$this->parent) return false; #both parent and iterator are null
        if (!$this->iterator->valid()) { #back to parent
           $this->iterator = $this->parent;
           $this->iterator->next();
           $this->parent = null;
        }
        return $this->iterator->valid();
    }
    public function rewind()
    {
        $this->iterator->rewind();
    }
    public function next()
    {
        $this->iterator->next();
    }
    public function key()
    {
        return $this->iterator->key();
    }
}
$dr_iter = new DeepRecursiveArrayIterator($arr23);
foreach ($dr_iter as $i) {
    var_dump($i);
}
/**
 * RecursiveIteratorIterator
 *  - __construct ( Traversable $iterator )
 * 
 * AUTOMATIC TRAVERSING CHILDREN!
 *
$iter_i = new RecursiveIteratorIterator($iter_r2, RecursiveIteratorIterator::LEAVES_ONLY);
foreach ($iter_i as $i => $v) {
    //var_dump($v);
}
/**
 * RecursiveTreeIterator
 *  - __construct RecursiveIterator(array of array)
 */
//$iter_i = new RecursiveTreeIterator($arr); #NOP must be traversable
//$iter_i = new RecursiveTreeIterator($iter); #NOP ! must be RecursiveIterator
//$iter_i = new RecursiveTreeIterator($iter_r1); #ok but NOP ! ArrayIterator to string convertion
//$iter_i = new RecursiveTreeIterator($iter_r); #ok
$iter_tree = new RecursiveTreeIterator($iter_arr); #OK GOOD RecursiveIterator(array of array)
foreach ($iter_tree as $i => $v) {
    //var_dump($v);
}
/*
 * RecursiveDirectoryIterator (path):  
 *  - FilesystemIterator (path, FLAG)
 *
$dirs = new RecursiveDirectoryIterator(__DIR__); 
/*foreach ($dirs as $path => $splinfo) {
    echo $splinfo->getFilename().'<br/>';
    //var_dump(get_class_methods($splinfo));
}*
//$its = new RecursiveIteratorIterator($iter);
/*foreach ($its as $k => $it) {
    var_dump($k);
}*
/*
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
 
*/