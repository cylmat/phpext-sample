<?php

declare(strict_types=1);

namespace Iterator;

/*
 * REF PHP
 *
 * IteratorAggregate (getIterator)
 *     - return a Traversable object
 */
class MyIterAggregate implements \IteratorAggregate #Traversable
{
    public function getIterator() #: Traversable
    {
        return ($this->generate(5));
    }
    
    private function generate($val) #Generator
    {
        for ($i = 0; $i < $val; $i++) {
            yield $i;
        }
    }
}
