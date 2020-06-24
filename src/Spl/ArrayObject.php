<?php


/**
 * CLASSES SPL
 * 
 * ArrayObject 
 *  - getArray()
 *  - offset Accesses[] 
 * 
 *  - getIterator() # SPL ArrayIterator
 */
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
}
