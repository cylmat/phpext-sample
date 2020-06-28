<?php

declare(strict_types=1);

namespace Spl;

 /**
  * INTERFACES SPL
  * OuterIterator (getInnerIterator)
  * RecursiveIterator (getChildren)
  * Seekable
  */
class Outer implements \OuterIterator
{
    private $iterator;

    public function __construct(\Iterator $i)
    {
        $this->iterator = $i;
    }
    public function current()
    {
        return $this->iterator->current();
    }
    public function key()
    {
        return $this->iterator->key();
    }
    public function next(): void
    {
        $this->iterator->next();
    }
    public function rewind(): void
    {
        $this->iterator->rewind();
    }
    public function valid(): bool
    {
        return $this->iterator->valid();
    }
    public function getInnerIterator(): \Iterator
    {
        return $this->iterator;
    }
}
