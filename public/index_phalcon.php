<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/index_phalcon.php',
    function () {
        echo "<h1>Phalcon Home!</h1>";
    }
);

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);

/**
 * Namespaces
 */
/*$loader->registerNamespaces(
    [
        'App\Controllers' => $config->application->controllersDir,
        'App\Models' => $config->application->modelsDir
    ]
)->register();
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();*/