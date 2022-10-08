<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

include __DIR__.'/../vendor/autoload.php';

$dirs = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__));
foreach ($dirs as $file) {
    $class = \str_replace([__DIR__.'/', '.php'], '', $file->getRealpath());
    $class = 'Phpext\\' . \str_replace(['/'], ['\\'], $class);

    if (\class_exists($class)) {
        echo $class."\n";
    }
}
