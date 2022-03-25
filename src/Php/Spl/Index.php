<?php

declare(strict_types=1);

namespace Phpext\Php\Spl;

use Phpext\CallableInterface;

class Index implements CallableInterface
{
    public function call(): array
    {
        return [];
    }

    public function arrayObject()
    {
        $array = [2,5,9,6];
        $obj = new \ArrayObject($array, 0, 'ArrayIterator');
        $obj->asort();
        $obj->exchangeArray(array_merge($array, ['plus' => 'inside']));
        $obj->append('fois');
        $obj->offsetSet('quatre', 'gamma');
        $iter = $obj->getIterator();
        $copy = $obj->getArrayCopy();

        foreach ($obj as $k => $val) {
            echo $k . ':' . $val . '-';
        }
    }

    public function outerIterator()
    {
        $iter = new \ArrayIterator([9,5,1,4,7]);

        $outer = new Outer($iter);
        foreach ($outer as $k) {
            // var_dump($k);
            echo $k;
        }
    }
}
