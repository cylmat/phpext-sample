<?php

namespace Phpext;

include __DIR__.'/../src/bootstrap.php';

$dirs = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator(__DIR__ . '/../src'), \RecursiveIteratorIterator::LEAVES_ONLY
);

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
            $key = str_replace(['Phpext\\', '\\Index'], ['', ''], $class);
            
            try {
                $class = new $classname;
                $results[$key] = $class->call();
            } catch (\E_USER_ERROR $error) {
                $results[$key] = [$classs::EXT];
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
