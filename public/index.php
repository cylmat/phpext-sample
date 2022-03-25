<?php

namespace Phpext;

include __DIR__.'/../src/bootstrap.php';

$dirs = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator(__DIR__ . '/../src'), \RecursiveIteratorIterator::LEAVES_ONLY
);

set_error_handler(function($level, $message, $file, $line) {
    throw new \ErrorException($message, $level, 1, $file, $line);
});

/*************************************
 * LOAD ALL DISPLAYABLE FILES 'INDEX'
 *************************************/

$results = [];
foreach ($dirs as $file) {
    /** @var \SplFileInfo $file */
    $name = $file->getFilename();

    if ('Index.php' === $name) {
        preg_match('/\.\.\/src\/(.+).php$/', $file->getPathname(), $match);

        if (key_exists(1, $match)) {
            $classname = 'Phpext\\'.str_replace('/', '\\', $match[1]);
            $key = str_replace(['Phpext\\', '\\Index'], ['', ''], $classname);
            $class = new $classname();
            
            try {
                $results[$key] = $class->call();
            } catch (\ErrorException $error) {
                $results[$key] = ['<span style="color: red">Extension ' . $class::EXT . ' not loaded !</span>'];
            }
        }
    }

    ksort($results);
}

/*******************
 * DISPLAY TEMPLATE
 *******************/
echo '<html><body>

<center style="width:70%; margin:auto">
<div style="text-align:left"><h2>Phpext</h2><h3>Playground with php extensions</h3></div>';
foreach ($results as $class => $result) {
    echo '<fieldset style="display: block; text-align: left"><legend>'.$class.'</legend><div>' .
            join(", ", $result) .
        "</div></fieldset>";
}
echo "</center>";
echo "</body></html>";
