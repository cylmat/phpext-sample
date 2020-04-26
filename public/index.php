<?php

error_reporting(E_ALL);
ini_set('display_errors','on');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';
define('ROOT', __DIR__.'/..');

// app
$app = AppFactory::create();

$index = <<<R
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Php-Pear-Pecl experience</title>
        <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
        <style>
            body {
                margin: 10px 0 0 0;
                padding: 0;
                width: 100%%;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-align: center;
                color: #333;
                font-size: 18px;
            }

            h1 {
                color: #719e40;
                letter-spacing: -3px;
                font-family: 'Lato', sans-serif;
                font-size: 100px;
                font-weight: 200;
                margin-bottom: 0;
            }

            .menu {
                color: #aaa;
                margin-bottom: 30px
            }
        </style>
    </head>
    <body>
        <h1>Php Pear Pecl</h1>
        <div class="menu">%s</div>
        <div>%s</div>
    </body>
</html>
R;

/**
 * Directories
 */
$src = new DirectoryIterator('../src');
$dir = [];
foreach($src as $sub) {
    $b = $sub->getBasename();
    if(strpbrk($b,'._')) continue;
    $dir[] = " <a href='/{$b}'>{$b}</a> ";
}
$index = sprintf($index,implode(' ',$dir),'%s');

/**
 * HOME
 */
$app->get('/', function (Request $request, Response $response, $args) use ($index) {
    $response->getBody()->write(sprintf($index,'',''));
    return $response;
});

/* 
 * Routers 
 * ns/ctrl/Action/params
 */
$app->get('/{ns}[/{ctrl}[/{action}[/{params:[a-z0-9\/]+}]]]', function (Request $request, Response $response, $args) use ($index) {
    
    $n = (($args['ns'] ?? ''));
    $a = ($args['action'] ?? 'index');
    $c = (($args['ctrl'] ?? 'index'));

    $ns = ucfirst($n) . '\\';
    $ctrl = ucfirst($c) . '';
    $action = $a . '';
    $params = explode('/',($args['params'] ?? ''));
    $params = isset($args['params']) ? $params : null;
    $class = "{$ns}{$ctrl}";

    $class = new $class();
    if($params) $args=$class->$action(...$params);
    else $args=$class->$action();

    $dir = __DIR__."/../src/{$n}/";
    $renderer = new PhpRenderer($dir);

    if(file_exists($dir . $a.'phtml')) {
        return $renderer->render($response, "{$a}.phtml", $args);
    } else {
        $v = $args ? var_export($args, true) : '';
        $response->getBody()->write(sprintf($index,'',$v));
        return $response;
    }
});

// run
$app->run();