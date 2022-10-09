<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

include __DIR__.'/../vendor/autoload.php';

$argv = $argv ?? [];
$arguments = function() use ($argv) {
    if ('--help' === ($argv[1] ?? null)) {
        echo <<<H
\nUsage:
    test.php <filename> e.g. "CurlExt"
    --help: This help message\n
H;
        exit (0);
    }

    return [
        'filename' => $argv[1] ?? null,
    ];
};

$dirs = new RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__));
foreach ($dirs as $file) {
    $class = \str_replace([__DIR__.'/', '.php'], '', $file->getRealpath());
    $class = 'Phpext\\' . \str_replace(['/'], ['\\'], $class);

    /** @todo make it works */
    if (false !== \strpos($class, 'Db')) {
        continue;
    }

    if (false !== \strpos($class, 'Intl')) {
        continue;
    }

    if (false !== \strpos($class, 'Phar')) {
        continue;
    }

    if (false !== \strpos($class, 'Soap')) {
        continue;
    }

    if (false !== \strpos($class, 'Socket')) {
        continue;
    }

    $filename = $arguments()['filename'];
    if (\class_exists($class)) {
        //specific filename
        if ($filename && \preg_match('/'.ucfirst($filename).'$/', $class)) {
            (new $class())->call();
            exit (0);
        }

        // all files
        if (\is_callable($class)) {
            (new $class())->call();
        }
    }
}
exit(0);
