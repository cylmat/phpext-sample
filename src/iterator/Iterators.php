<?php

declare (strict_types = 1);

namespace Iterator;

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
class Iterators
{
    public function arrayIterator()
    {
        $iter = new \ArrayIterator(['john','flush']);
        $r=[];
        foreach ($iter as $content) {
            echo $content;
        }
    }

    /**
     * La classe DirectoryIterator fournit une interface simple pour lire le contenu d'un système de fichiers. 
     */
    public function directoryIterator()
    {
        $dir = new \DirectoryIterator(ROOT.'/src');
        foreach ($dir as $sub) {
           echo $dir->getFilename().'<br/>';
        }
    }
}









/*
//$logs = new DirectoryIterator('.');
$array = ['chemise', 'rouge', 'alphonse'=>'3', 'blue car', 'maze', 'donald'=>5];
/**
 * PHP
 * 
 * Interface for iterator (current, key, rewind, next, valid)
 *
class MonIterator implements Iterator #Traversable
{
    protected $zero = 'propriete';
    protected $un = 'access';
    protected $semaphore='3';
    protected $quatre = 'extrait';
    protected $cinq = 'partie';
    protected $différence = 887;
    private $_pointer='zero';
    private $_keys = [];
    public function __construct()
    {
        $this->_keys = array_diff(array_keys(get_class_vars(self::class)), ['_pointer','_keys']);
    }
    public function set($name, $value): bool
    {
        if(property_exists($this, $name) && in_array($name, $this->_keys))  {
            $this->$name = $value;
            return true;
        }
        return false;
    }
    public function get($name)
    {
        if(property_exists($this, $name) && in_array($name, $this->_keys)) 
            return $this->$name;
        return null;
    }
     public function current (  ) #mixed
     {
        return $this->get($this->_pointer);
     }
     public function key (  ) #mixed
     {
        return $this->pointer;
     }
     public function next (  ) : void
     {
        $this->_pointer = next($this->_keys);
     }
     public function rewind (  ) : void
     {
        $this->_pointer = 'zero';
     }
     public function valid (  ) : bool
     {
        return property_exists($this, $this->_pointer);
     }
}
$iter = new MonIterator;
$iter->next();
/*
 * REF PHP
 * 
 * IteratorAggregate (getIterator)
 *     - return a Traversable object
 *
class IterAggregate implements IteratorAggregate #Traversable
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
$iterA = new IterAggregate;
foreach ($iterA as $value) {
   // echo $value.'
';
}
 /**
  * INTERFACES SPL
  * OuterIterator (getInnerIterator)
  * RecursiveIterator (getChildren)
  * Seekable
  *
class Outer implements OuterIterator
{
    private $iterator;
    public function __construct(Iterator $i)
    {
        $this->iterator = $i;
    }
     public function current (  ) 
     {
        return $this->iterator->current();
     }
     public function key (  ) 
     {
        return $this->iterator->key();
     }
     public function next (  ) : void
     {
        $this->iterator->next();
     }
     public function rewind (  ) : void
     {
        $this->iterator->rewind();
     }
     public function valid (  ) : bool
     {
        return $this->iterator->valid();
     }
      public function getInnerIterator (  ) : Iterator
      {
        return $this->iterator;
      }
}
$outer = new Outer($iter);
foreach ($outer as $k) {
   // var_dump($k);
}
/**
 * CLASSES SPL
 * 
 * ArrayObject 
 *  - getArray()
 *  - offset Accesses[] 
 * 
 *  - getIterator() # SPL ArrayIterator
 *
class MyObject extends ArrayObject #IteratorAggregate, ArrayAccess
{
}
$obj = new MyObject($array, 0, 'ArrayIterator');
$obj->asort();
$obj->exchangeArray(array_merge($array,['plus'=>'inside']));
$obj->append('fois');
$obj->offsetSet('quatre', 'gamma');
$iter = $obj->getIterator();
$copy = $obj->getArrayCopy();
foreach ($obj as $k => $val) {
    //echo $k.':'.$val.'
';
}
                                            /******* SPL ITERATORS *********/
/*
 * ArrayIterator
 *  - réinitialiser et de modifier les valeurs et les clés
 * 
 *  SeekableIterator (seek, current, key, next, rewind, valid)
*
class MyIterator extends ArrayIterator
{
}
/*
 * IteratorIterator (outer)
 *  - conversion de n'importe quel objet Traversable en un itérateur
 *
class MyIterIter extends IteratorIterator #OuterIterator
{
    function current()
    {
        return parent::current() . 'plus';
    }
}
$ii = new MyIterIter(new ArrayIterator(['deli', 'satir', 'plus']));
$ii->rewind();
while ($ii->valid()) {
    $ii->next();
}
/*
 * FilterIterator 
 *  - accept
 *
class LogFilterIterator extends FilterIterator #IteratorIterator (outer)
{
    public function accept(): bool
    {
        if(!preg_match('/^110\./',$this->getInnerIterator()->current())) return true;
        return false;
    }
}
$ipFilter = new LogFilterIterator(new ArrayIterator([10=>'10.21.510.6', 15=>'10.21.510.9', 25=>'110.21.510.2']));
foreach ($ipFilter as $ip)
{
    echo $ip.'
';
}
*/