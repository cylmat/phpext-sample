<?php

namespace Phpext;

ini_set('display_errors', 'on');
error_reporting(-1);

spl_autoload_register(function(string $classname) {
    $classfile = str_replace('\\', '/', $classname) . '.php';
    $classfile = __DIR__.str_replace(__NAMESPACE__, '', $classfile);

    if (file_exists($classfile)) {
        require_once $classfile;
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