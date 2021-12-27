<?php

declare(strict_types=1);

namespace Phpext\Php\Iterator;

/*
 * IteratorIterator (outer)
 *  - conversion de n'importe quel objet Traversable en un itérateur
 */
class MyIterIter extends \IteratorIterator #OuterIterator
{
    public function current()
    {
        return parent::current() . 'plus';
    }
}
