<?php

use Src\Request;
use Src\Router;
use Src\Runner;

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$router = new Router();

$router->get('/test', function (Request $request) {
    echo "b";
});

$router->get('/test/{id}', function (Request $request, $id) {
    echo $id;
});


$router->get('/test/{a}/{b}', function (Request $request, $a, $b) {
    echo "$a . $b";
});

$router->get('/test/{a}/testing/{b}', function (Request $request, $a, $b) {
    echo "$a . $b";
});


$runner = new Runner($router);
$runner->run();