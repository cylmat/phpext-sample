<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

if (php_sapi_name() == 'cli-server') {
    include __DIR__.'/../../vendor/autoload.php';
}

$s = (new \Soap\Server);
$s->create();
$s->handle();
