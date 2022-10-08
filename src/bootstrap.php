<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

spl_autoload_register(function(string $classname) {
    $classfile = str_replace('\\', '/', $classname) . '.php';
    $classfile = __DIR__ . str_replace(__NAMESPACE__, '', $classfile);
    include_once $classfile;
});
