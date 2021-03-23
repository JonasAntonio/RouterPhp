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

    public function get($url, $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'GET');
    }

    public function post($url, $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'POST');
    }

    public function put($url, $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'PUT');
    }

    public function delete($url, $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'DELETE');
    }

    public function patch($url, $callback) 
    {
        $this->setRegisteredUrls($url, $callback, 'PATCH');
    }
    
    public function getRegisteredUrls($method = '')
    {
        return empty($method) ? $this->registeredUrls : $this->registeredUrls[$method];
    }

    public function setRegisteredUrls($url, $callback, $method) 
    {
        $this->registeredUrls[$method][$url] = $callback;
    }

    private function getUrlPieces($url)
    {
        if(substr($url, 0, 1) == '/') $url = substr($url, 1);
        if(substr($url, -1) == '/')   $url = substr($url, 0, -1);
        return strpos($url, '/') !== false ? explode('/', $url) : array($url);
    }

    public function validateUrl()
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
