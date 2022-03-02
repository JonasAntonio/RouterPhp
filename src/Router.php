<?php

namespace Src;

use Closure;

class Router
{
    /**
     * @var array [method][hasPathParams][url] => Route
     */
    private array $routes;
    private Request $request;

    public function __construct()
    {
        $this->routes = [];
        $this->request = new Request();
    }

    public function getRoutesByMethod(string $method): array
    {
        return $this->routes[$method];
    }

    /**
     * @author Jonas Vicente
     * @param string $url Endpoint para ser adicionado às rotas GET do sistema
     * @param Closure $callback
     * @return Route
     */
    public function get(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'GET');
    }

    /**
     * @author Jonas Vicente
     * @param string $url Endpoint para ser adicionado às rotas POST do sistema
     * @param Closure $callback
     * @return Route
     */
    public function post(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'POST');
    }

    /**
     * @author Jonas Vicente
     * @param string $url Endpoint para ser adicionado às rotas PUT do sistema
     * @param Closure $callback
     * @return Route
     */
    public function put(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PUT');
    }

    /**
     * @author Jonas Vicente
     * @param string $url Endpoint para ser adicionado às rotas DELETE do sistema
     * @param Closure $callback
     * @return Route
     */
    public function delete(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'DELETE');
    }

    /**
     * @author Jonas Vicente
     * @param string $url Endpoint para ser adicionado às rotas PATCH do sistema
     * @param Closure $callback
     * @return Route
     */
    public function patch(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PATCH');
    }

    public function any($url, $callback, $before = array(), $after = array())
    {
        switch ($this->request->getMethod()) {
            case 'GET':
                return $this->get($url, $callback, $before, $after);
            case 'POST':
                return $this->post($url, $callback, $before, $after);
            case 'PUT':
                return $this->put($url, $callback, $before, $after);
            case 'DELETE':
                return $this->delete($url, $callback, $before, $after);
            case 'PATCH':
                return $this->patch($url, $callback, $before, $after);
        }
    }

    /**
     * Registra as rotas no sistema
     * @author Jonas Vicente
     * @param string $url
     * @param Closure $callback
     * @param string $method
     * @return Route
     */
    private function addRoute(string $url, Closure $callback, string $method): Route
    {
        $url = Str::setUrlPattern($url);
        $pathParams = $this->request->getPathParams($url);

        return $this->routes[$method][$pathParams !== []][$url] = new Route($callback, $pathParams);
    }
}
