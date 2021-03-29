<?php

class Router
{
    private $requestedUrl      = "";
    private $requestedMethod   = "";
    private $registeredUrls = array();

    public function __construct()
    {
        $this->requestedUrl    = $_SERVER['REQUEST_URI'];
        $this->requestedMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function run()
    {
        $requestedUrl = $this->requestedUrl;
        $routes       = $this->getRegisteredUrls($this->requestedMethod);
        $callback     = isset($routes[$requestedUrl]) ? $routes[$requestedUrl] : false;
        if($callback !== false) {
            echo call_user_func($callback);
            exit;
        }
        header('HTTP/1.0 404');
        header('Content-Type: application/json');
        echo json_encode(array('retorno'=>'erro', 'mensagem'=>"Caminho não encontrado."));
        exit;
    }

    public function get($url, Closure $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'GET');
    }

    public function post($url, Closure $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'POST');
    }

    public function put($url, Closure $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'PUT');
    }

    public function delete($url, Closure $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'DELETE');
    }

    public function patch($url, Closure $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'PATCH');
    }
    
    public function getRegisteredUrls($method = '')
    {
        return empty($method) ? $this->registeredUrls : $this->registeredUrls[$method];
    }

    public function setRegisteredUrls($url, $callback, $method) 
    {
        $this->registeredUrls[$method][$this->setUrlPattern($url)] = $callback;
    }

    private function getUrlPieces($url)
    {
        if(substr($url, 0, 1) == '/') $url = substr($url, 1);
        if(substr($url, -1) == '/')   $url = substr($url, 0, -1);
        return strpos($url, '/') !== false ? explode('/', $url) : array($url);
    }

    private function setUrlPattern($url)
    {
        if(substr($url, 0, 1) != '/') $url  = '/'.$url;
        if(substr($url, -1) != '/')   $url .= '/';
        return $url;
    }

    private function validateUrl()
    {
        $requestedUrl = $this->requestedUrl;
        $requestedMethod = $this->requestedMethod;
        $urls = $this->getRegisteredUrls($requestedMethod);

        // quebrar as strings de url e verificar se há variável
        // se houver, substituir o valor na requestedUrl pelo nome da variável da url registrada

        $urlArrayIndex = array_search($requestedUrl, array_column($urls, 'url'));

        return $urlArrayIndex !== false;
    }

    private function validateRequestMethod($method)
    {
        $methods = array('GET', 'POST', 'PUT', 'DELETE', 'PATCH');
        if(!in_array(strtoupper($method), $methods)) throw new Exception("Método de requisição '".$method."' não reconhecido.", 2);
        return true;
    }
}
