<?php

ini_set('display_errors', 'on');
error_reporting(-1);

define('SRC', __DIR__ . '/');

spl_autoload_register(function(string $classname){
    $base = __DIR__ . '/'; 
    $recdirs = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base), RecursiveIteratorIterator::LEAVES_ONLY
    );

    $classfile = str_replace('\\', '/', $classname) . '.php';
    foreach ($recdirs as $filesys) {
        if ($filesys->getExtension() !== 'php' && $filesys->isFile()) continue;
        if (false !== strpos($filesys->getRealpath(), $classfile)) {
            include_once $filesys->getRealpath();
        }
    }
});

function b($limit=0) //Backtrace
{
    $b = debug_backtrace(0, $limit); array_shift($b); $res = [];
    array_walk($b, function($v, $i) use (&$res) {
        $args = [];
        array_walk($v['args'], function($v) use (&$args) {
            $args[] = is_object($v) ? get_class($v) : (
                is_array( $v ) ? '[array]' : $v
            );
        });
        $res[] = $v['class'] . ':' . $v['function'] . '('. ($args ? ' '.join(',', $args).' ' : '') .')' . ':' . $v['line'];
    }); 
    var_dump($res); 
}