<?php

declare (strict_types = 1);

namespace Iterator;

defined('ROOT') or define('ROOT', __DIR__.'/../..');

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

class Iterators {}





/*

                                            /******* SPL ITERATORS *********/
/*
 * ArrayIterator
 *  - réinitialiser et de modifier les valeurs et les clés
 * 
 *  SeekableIterator (seek, current, key, next, rewind, valid)
*/
class MyArrayIterator extends \ArrayIterator
{

}

/*
 * REF PHP
 * 
 * IteratorAggregate (getIterator)
 *     - return a Traversable object
 */
class MyIterAggregate implements \IteratorAggregate #Traversable
{
    private function generate($val) #Generator
    {
        for($i=0;$i<$val;$i++)
        yield $i;
    }
    public function getIterator() #: Traversable
    {
        return ($this->generate(5));
    }
}

/*
 * IteratorIterator (outer)
 *  - conversion de n'importe quel objet Traversable en un itérateur
 */
class MyIterIter extends \IteratorIterator #OuterIterator
{
    function current()
    {
        return parent::current() . 'plus';
    }
}

/*
 * FilterIterator 
 *  - accept
 */
class MyLogFilterIterator extends \FilterIterator #IteratorIterator (outer)
{
    public function accept(): bool
    {
        if(!preg_match('/^110\./',$this->getInnerIterator()->current())) return true;
        return false;
    }
}


