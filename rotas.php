<?php
require_once 'Router.php';
require_once 'ControllerTeste.php';

$router          = new Router();
$controllerTeste = new ControllerTeste();

$router->get('/Router/teste/{id}', function($id){
    // $controllerTeste->
});
$router->post('/Router/teste/update/{id}', function($id){
    // $controllerTeste->
});
$router->get('/Router/teste/list', function(){
    // $controllerTeste->list();
});
$router->post('/Router/teste/add', function(){
    // echo "teste";
});


echo "<pre>";
var_dump($router->getRegisteredUrls());