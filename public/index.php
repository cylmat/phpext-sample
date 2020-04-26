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
                width: 100%;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-align: center;
                color: #333;
                font-size: 18px;
            }

            a {
                text-decoration: none;
            }

            h1 {
                color: #719e40;
                letter-spacing: -3px;
                font-family: 'Lato', sans-serif;
                font-size: 40px;
                font-weight: 100;
                margin-bottom: 0;
            }

            .menu {
                color: #aaa;
                text-transform: uppercase;
            }

            .submenu {
                color: #aaa;
                margin-bottom: 30px
            }
        </style>
    </head>
    <body>
        <h1>Php Pear Pecl</h1>
        <div class="menu">*MENU*</div>
        <div class="submenu">*SUB*</div>
        <div class="content">*CONTENT*</div>
    </body>
</html>
R;

/**
 * Top menu 
 */
$src = new DirectoryIterator(ROOT . '/src');
$dir = [];
foreach($src as $sub) {
    $b = $sub->getBasename();
    if(strpbrk($b,'._')) continue;
    $dir[] = " <a href='/{$b}'>{$b}</a> ";
}
$index = str_replace('*MENU*',implode($dir),$index);

/**
 * HOME
 */
$app->get('/', function (Request $request, Response $response, $args) use ($index) {
    $i = str_replace(['*SUB*','*CONTENT*'],['',''],$index);
    $response->getBody()->write($i);
    return $response;
});

/* 
 * Routers 
 * ns/ctrl/Action/params
 */
$app->get('/{ns}[/{ctrl}[/{action}[/{params:[a-z0-9\/]+}]]]', function (Request $request, Response $response, $args) use ($index) {
    
    // args
    $n = (($args['ns'] ?? ''));
    $c = (($args['ctrl'] ?? 'index'));
    $a = ($args['action'] ?? 'index');

    $ns = ucfirst($n) . '\\';
    $ctrl = ucfirst($c) . '';
    $action = $a . '';
    $params = explode('/',($args['params'] ?? ''));
    $params = isset($args['params']) ? $params : null;
    $class = "{$ns}{$ctrl}";

    // init class
    ob_start();
    $class = new $class();
    if($params) $args=$class->$action(...$params);
    else $args=$class->$action();
    $echoed = ob_get_contents();
    ob_end_clean();

    // view dir
    $dir = __DIR__."/../src/{$n}/";
    $renderer = new PhpRenderer($dir);

    // reflection for actions methods
    $methods = (new ReflectionClass($class))->getMethods();
    $sub = '';
    foreach ($methods as $k => $m) {
        $sub .= " <a href='/{$n}/{$c}/{$m->name}'>{$m->name}</a> ";
    }

    // load rendered
    if (file_exists($dir . $a.'.phtml')) {
        return $renderer->render($response, "{$a}.phtml", $args);
    } else {
        $v = $args ? var_export($args, true) : '';
        $i = str_replace(['*SUB*','*CONTENT*'],[$sub,$echoed],$index);
        $response->getBody()->write($i);
        return $response;
    }
});

// run
$app->run();