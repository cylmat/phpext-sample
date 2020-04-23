<?php

error_reporting(E_ALL);
ini_set('display_errors','on');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

// app
$app = AppFactory::create();

/* 
 * Routers 
 * ns/ctrl/Action/params
 */
$app->get('/', function (Request $request, Response $response, $args) {
    $dir = __DIR__."/../src/index/templates";
    $renderer = new PhpRenderer($dir);
    return $renderer->render($response, "index.phtml", $args);
});

$app->get('/{ns}[/{ctrl}[/{action}[/{params:[a-z0-9\/]+}]]]', function (Request $request, Response $response, $args) {
    
    $n = (($args['ns'] ?? ''));
    $a = ($args['action'] ?? 'index');
    $c = (($args['ctrl'] ?? 'Index'));

    $ns = ucfirst($n) . '\\';
    $ctrl = ucfirst($c) . 'Controller';
    $action = $a . 'Action';
    $params = explode('/',($args['params'] ?? ''));
    $params = isset($args['params']) ? $params : null;
    $class = "{$ns}Controllers\\{$ctrl}";

    $class = new $class();
    if($params) $class->$action(...$params);
    else $class->$action();

    $dir = __DIR__."/../src/{$n}/templates";
    $renderer = new PhpRenderer($dir);
    return $renderer->render($response, "{$a}.phtml", $args);
    //$response->getBody()->write("Hello, 7");
    //return $response;
});

// run
$app->run();
