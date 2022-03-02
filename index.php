<?php

use Src\Request;
use Src\Router;
use Src\Runner;

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$router = new Router();

for ($i = 0; $i < 1000; $i++) {

    $router->get("/test$i/{id}", function (Request $request, $id) {
        echo "{id}: $id";
    });

    $router->get("/user$i/{id}", function (Request $request, $id) {
        echo "{id}: $id";
    });

    $router->get("/test$i/{a}/{b}", function (Request $request, $a, $b) {
        echo "{a}: $a . {b}: $b";
    });
}

$router->get("/no-path-parameter", function (Request $request) {
    echo "No path parameter";
});

$router->get("/test/{a}/testing/{b}", function (Request $request, $a, $b) {
    echo "{a}: $a . {b}: $b";
});


$start = round(microtime(true) * 1000);

$runner = new Runner($router);
$runner->run();

$end = round(microtime(true) * 1000);

$time = $end - $start;

$memory = memory_get_usage(true);

echo "<br><br>";

if ($memory < 1024)
    $memory = $memory . " bytes";
elseif ($memory < 1048576)
    $memory = round($memory / 1024, 2) . " kilobytes";
else
    $memory = round($memory / 1048576, 2) . " megabytes";

echo "Memory: $memory <br>";
echo "Time: $time miliseconds";
