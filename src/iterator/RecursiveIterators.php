<?php

declare(strict_types=1);

namespace Iterator;

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
class RecursiveIterators {}



                                            /********* Recursive **************
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
    //echo $iter_a->current().'<br/>'; #ERROR, convert iterator to string!
    $iter_r->next();
}

$dr_iter = new MyRecursiveArrayIterator($arr23);
foreach ($dr_iter as $i) {
    var_dump($i);
}
/**
 * RecursiveIteratorIterator
 *  - __construct ( Traversable $iterator )
 * 
 * AUTOMATIC TRAVERSING CHILDREN!
 */
$iter_i = new \RecursiveIteratorIterator($iter_r2, \RecursiveIteratorIterator::LEAVES_ONLY);
foreach ($iter_i as $i => $v) {
    //var_dump($v);
}
/**
 * RecursiveTreeIterator
 *  - __construct RecursiveIterator(array of array)
 */
//$iter_i = new RecursiveTreeIterator($arr); #NOP must be traversable
//$iter_i = new RecursiveTreeIterator($iter); #NOP ! must be RecursiveIterator
//$iter_i = new RecursiveTreeIterator($iter_r1); #ok but NOP ! ArrayIterator to string convertion
//$iter_i = new RecursiveTreeIterator($iter_r); #ok
$iter_tree = new \RecursiveTreeIterator($iter_arr); #OK GOOD RecursiveIterator(array of array)
foreach ($iter_tree as $i => $v) {
    //var_dump($v);
}
/*
 * RecursiveDirectoryIterator (path):  
 *  - FilesystemIterator (path, FLAG)
 */
$dirs = new \RecursiveDirectoryIterator(__DIR__); 
/*foreach ($dirs as $path => $splinfo) {
    echo $splinfo->getFilename().'<br/>';
    //var_dump(get_class_methods($splinfo));
}*/
//$its = new RecursiveIteratorIterator($iter);
/*foreach ($its as $k => $it) {
    var_dump($k);
}*/
/*
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
 
*/