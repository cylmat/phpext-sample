<?php

session_start();

function d(...$v) 
{
    var_dump(...$v);
}

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
    d($res); 
}

require __DIR__ . '/../vendor/autoload.php';
define('ROOT', __DIR__.'/..');
