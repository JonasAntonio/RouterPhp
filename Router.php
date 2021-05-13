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
        $requestedUrl = $this->setUrlPattern($this->requestedUrl);
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
    
    private function getRegisteredUrls($method = '')
    {
        return empty($method) ? $this->registeredUrls : $this->registeredUrls[$method];
    }

    private function setRegisteredUrls($url, $callback, $method) 
    {
        $this->registeredUrls[$method][$this->setUrlPattern($url)] = $callback;
    }

    private function setUrlPattern($url)
    {
        if(strpos($url, '?')) {
            $url = explode('?', $url);
            $url = $url[0];
        }
        if(substr($url, 0, 1) != '/') $url  = '/'.$url;
        if(substr($url, -1) != '/')   $url .= '/';
        return $url;
    }
}
