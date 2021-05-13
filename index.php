<?php

//Capturar Json
$requisicao = explode('?', $_SERVER['REQUEST_URI']);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $requisicao = $requisicao[0].'/'.$_SERVER['REQUEST_METHOD'];
    $json = json_encode($_GET);
} else {
    $json = file_get_contents('php://input');   
    $final = substr($requisicao[0], -1);

    if ($final == '/') {
        $requisicao = $requisicao[0].$_SERVER['REQUEST_METHOD'];
    } else {
        $requisicao = $requisicao[0].'/'.$_SERVER['REQUEST_METHOD'];
    }
}

$json = json_encode($json);

require_once 'rotas.php';