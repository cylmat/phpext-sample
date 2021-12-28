<?php

namespace Phpext;

include __DIR__.'/../src/bootstrap.php';

$dirs = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator(__DIR__ . '/../src'), \RecursiveIteratorIterator::LEAVES_ONLY
);

$results = [];

foreach ($dirs as $file) {
    /** @var \SplFileInfo $file */
    $name = $file->getFilename();

    if ('Index.php' === $name) {
        preg_match('/\.\.\/src\/(.+).php$/', $file->getPathname(), $match);
        
        if (key_exists(1, $match)) {
            $class = 'Phpext\\'.str_replace('/', '\\', $match[1]);
            $results[str_replace(['Phpext\\', '\\Index'], ['', ''], $class)] = (new $class)->call();
        }
    }
}

echo '<html><body>

<center style="width:70%;margin:auto">
<div style="text-align:left"><h2>Phpext</h2><h3>Playground with php extensions</h3></div>';
foreach ($results as $class => $result) {
    echo '<fieldset style="float:left; width:20%; text-align: left"><legend>'.$class.'</legend>' .
            join("<br/>", $result) .
        "</fieldset>";
}
echo "</center>";
echo "</body></html>";