<?php

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