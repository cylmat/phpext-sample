<?php

declare(strict_types=1);

namespace Phpext\Php\Iterator;

use Phpext\AbstractCallable;

/*
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
RegexIterator
 */

/*
*  iterator_apply ( Traversable $iterator , callable $function [, array $args = NULL ] ) : int
*  iterator_count ( Traversable $iterator ) : int
*  iterator_to_array ( Traversable $iterator [, bool $use_keys = TRUE ] ) : array
*/

class Iterators extends AbstractCallable
{
    function call(): array
    {
        // @todo

        return [];
    }

    /************************************* classiques */

    public function arrays(array $array = ['john','flush'])
    {
        $iter = new MyArrayIterator($array);
        $r = [];
        foreach ($iter as $content) {
            echo $content . '<br/>';
        }
    }

    /**
     * interface
     */
    public function aggregate()
    {
        $iterA = new MyIterAggregate();
        foreach ($iterA as $value) {
            echo $value . '';
        }

        echo($iterA->getIterator())->current();
    }

    public function directory()
    {
        $dir = new \DirectoryIterator(__DIR__.'/../');
        foreach ($dir as $sub) {
            echo $dir->getFilename() . '<br/>';
        }
    }

    public function iterIter()
    {
        $ii = new MyIterIter(new \ArrayIterator(['deli', 'satir']));
        $ii->rewind();
        while ($ii->valid()) {
            echo $ii->current();
            $ii->next();
        }
    }

    
    public function filesystem()
    {
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
            echo $file . ':' . $path . '<br/>';
        }
        $sys = new \FilesystemIterator(__DIR__, \FilesystemIterator::CURRENT_AS_SELF);
        foreach ($sys as $path => $filesystem) {
            //echo $filesystem->getFilename().':'.$filesystem->getCTime().'';
        }
    }

    public function logFilter()
    {
        $arr_iter = new \ArrayIterator([10 => '10.21.510.6', 15 => '10.21.510.9', 25 => '110.21.510.2']);
        $ipFilter = new MyLogFilterIterator($arr_iter);
        foreach ($ipFilter as $ip) {
            echo $ip . ' ';
        }
    }











    /****************************** recursive *************************************** */
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
        */
    public function recursiveArray()
    {
        $arr = [5789,56234,55654,5353,5326,5998,597865];
        $arr2 = [94635,912354,9766,975,9654,95659,98646];
        $arr23 = [94635,912354,9766,$arr,9654,95659,98646];
        $iter = new \ArrayIterator($arr);
        $iter2 = new \ArrayIterator($arr2);
        new \RecursiveArrayIterator(new \DirectoryIterator(__DIR__)); #do nothing!
        $iter_r = new \RecursiveArrayIterator([5789,56234,55654,5353,5326,5998,597865]); #OK
        $iter_arr = new \RecursiveArrayIterator([5789,56234,$arr23,5353,5326,$arr,597865]); #OK
        $iter_r1 = new \RecursiveArrayIterator([2862,$iter2,287698,28753,$iter,27898,28978]); #no childrens
        $iter_r2 = new \RecursiveArrayIterator([865546,84456,8655436,811364,$iter_r1,8546,8654678]);
        #exemple ERROR
        #not infinity recursion
        $iter_r->rewind();
        while ($iter_r->valid()) {
            #echo $iter_a->current().'<br/>'; #ERROR, convert iterator to string!
            $iter_r->next();
        }

        $dr_iter = new MyRecursiveArrayIterator($arr23);
        foreach ($dr_iter as $i) {
            echo($i . '<br/>');
        }
    }

    public function recursiveDirectory()
    {
        /*
        * RecursiveDirectoryIterator (path):
        *  - FilesystemIterator (path, FLAG)
        */
        $dirs = new \RecursiveDirectoryIterator(__DIR__);
        foreach ($dirs as $path => $splinfo) {
            echo $splinfo->getFilename() . '<br/>';
            //var_dump(get_class_methods($splinfo));
        }
    }
    
    /**
         * La classe RecursiveDirectoryIterator fournit un moyen d'itérer récursivement sur des dossiers d'un système de fichiers.
         */
    public function recursiveDirectoryIterators()
    {
        $dirs = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__));
        
        $dirs->rewind();
        while ($dirs->valid()) {
            // RecursiveIteratorIterator
            if (!$dirs->isDot()) {
                echo $dirs->getFilename() . '<br/>';
            }
            $dirs->next();
        }
    }

    public function recursiveIterator()
    {
        $arr = [5789,56234,55654,5353,5326,5998,597865];
        $arr23 = [94635,912354,9766,$arr,9654,95659,98646];

        //doesn't work: An instance of RecursiveIterator or IteratorAggregate creating it is required
        #$iter = new \ArrayIterator(new \ArrayIterator($arr23));
        $iter = new \RecursiveArrayIterator(new \ArrayIterator($arr23));

        $its = new \RecursiveIteratorIterator($iter);
        foreach ($its as $k => $it) {
            echo($k . '-');
        }
        /**
         * RecursiveIteratorIterator
         *  - __construct ( Traversable $iterator )
         *
         * AUTOMATIC TRAVERSING CHILDREN!
         */
        $iter_i = new \RecursiveIteratorIterator($iter, \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($iter_i as $i => $v) {
            //var_dump($v);
        }
    }

    /**
     * IteratorIterator
     * Cet itérateur permet la conversion de n'importe quel objet Traversable en un itérateur
     */
    public function recursiveFiles()
    {
        $path = __DIR__;
        $rdi = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::KEY_AS_PATHNAME);
        foreach ($rdi as $file => $info) {
            echo $info->getFilename() . '<br>';
        }
        $d = new \RecursiveIteratorIterator($rdi, \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($d as $file => $info) {
            //echo $info->getFilename()."<br/>";
        }
    }

    public function recursiveRegex()
    {
        $path = new \RecursiveDirectoryIterator(__DIR__);
        $Iterator = new \RecursiveIteratorIterator($path);
        $Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($Regex as $k => $splinfo) {
            echo $splinfo[0] . '<br/>';
            break;
        }
    }

    public function recursiveTree()
    {
        /**
         * RecursiveTreeIterator
         *  - __construct RecursiveIterator(array of array)
         */
        //$iter_i = new RecursiveTreeIterator($arr); #NOP must be traversable
        //$iter_i = new RecursiveTreeIterator($iter); #NOP ! must be RecursiveIterator
        //$iter_i = new RecursiveTreeIterator($iter_r1); #ok but NOP ! ArrayIterator to string convertion
        //$iter_i = new RecursiveTreeIterator($iter_r); #ok

        $arr = [5789,56234,55654,5353,5326,5998,597865];
        $arr23 = [94635,912354,9766,$arr,9654,95659,98646];
        $iter_arr = new \RecursiveArrayIterator([5789,56234,$arr23,5353,5326,$arr,597865]); #OK

        $iter_tree = new \RecursiveTreeIterator($iter_arr); #OK GOOD RecursiveIterator(array of array)
        foreach ($iter_tree as $i => $v) {
            echo($v);
        }
    }
}
