<?php

/** @todo make it use AbstractCallable */
function load()
{

    if (php_sapi_name() == 'cli-server') {
        include __DIR__.'/../../vendor/autoload.php';
    }

    $s = (new \Soap\Server);
    $s->create();
    $s->handle();

}