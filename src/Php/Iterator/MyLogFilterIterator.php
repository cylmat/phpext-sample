<?php

declare(strict_types=1);

namespace Phpext\Php\Iterator;

/*
 * FilterIterator
 *  - accept
 */
class MyLogFilterIterator extends \FilterIterator #IteratorIterator (outer)
{
    public function accept(): bool
    {
        if (!preg_match('/^110\./', $this->getInnerIterator()->current())) {
            return true;
        }
        return false;
    }
}
