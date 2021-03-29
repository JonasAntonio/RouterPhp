<?php
require_once 'Router.php';
require_once 'ControllerTeste.php';

$router = new Router();
// $router->get('/Router/teste/{id}', function($id){
//     // $controllerTeste->
// });
// $router->post('/Router/teste/update/{id}', function($id){
//     // $controllerTeste->
// });
$router->get('/RouterPhp/teste/list/', function(){
    $controllerTeste = new ControllerTeste();
    echo $controllerTeste->list();
});
$router->post('/RouterPhp/teste/add/', function(){
    $controllerTeste = new ControllerTeste();
    echo $controllerTeste->add();
});

$router->run();