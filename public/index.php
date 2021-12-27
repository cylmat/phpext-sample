<?php

namespace Phpext;

include __DIR__.'/../src/bootstrap.php';

$dirs = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator(__DIR__ . '/../src'), \RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($dirs as $file) {
    /** @var \SplFileInfo $file */
    $name = $file->getFilename();

    if ('Index.php' === $name) {
        //$path = substr($file->getPathname(), strrpos($file->getPathname(), 'src/')+4);
        //$path = str_replace('.php', '', $path);
        preg_match('/\.\.\/src\/(.+).php$/', $file->getPathname(), $match);
        
        if (key_exists(1, $match)) {
            $class = 'Phpext\\'.str_replace('/', '\\', $match[1]);
            (new $class)->call();
        }
    }
}
