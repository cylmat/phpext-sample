<?php

/*
 * add 
   xhprof_param_init($params);
   $run = $params['run'] = $_GET['run'];

   in xhprof-html/index.php
   and xhprof-html/callgraph.php

   run: http://localhost:80/xhprof-html/?dir=/var/www/public/xhprof-html/tmp&run=<file.xhprof>
 */

//before
tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);

//after
$dir = "/var/www/tmp/" . date("Ymd") ;
file_exists($dir) || mkdir($dir);

$dir .= '/'. date("H-i-s") .'.xhprof';
file_put_contents(
    $dir,
    serialize(tideways_xhprof_disable())
);