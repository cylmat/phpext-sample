<?php

namespace Iterator;

// INFINITY
class MyRecursiveArrayIterator implements \Iterator
{
    protected $parent=null;
    protected $iterator=null;
    public function __construct(array $iterator)
    {
        $this->iterator = new \RecursiveArrayIterator($iterator);
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