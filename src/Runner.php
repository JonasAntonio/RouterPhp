<?php

namespace Src;

use Middleware\MiddlewareRunner;

class Runner
{
    private string $url;
    private Router $router;
    private Request $request;
    private array $urlParts;

    public function __construct(Router $router)
    {
        $this->request  = new Request();
        $this->url      = Str::setUrlPattern($this->request->getUrl());
        $this->router   = $router;
        $this->urlParts = explode("/", $this->url);
    }

    /**
     * Executa o projeto
     * @author Jonas Vicente
     * @return void
     */
    public function run(): void
    {
        $middleware = new MiddlewareRunner();

        $route  = $this->getRoute();
        $params = [$this->request];

        if ($route->pathParams !== []) {
            foreach (array_keys($route->pathParams) as $key) {
                $params[] = $this->urlParts[$key];
            }
        }

        $middleware->before($route);
        echo call_user_func_array($route->getCallback(), $params);
        $middleware->after($route);
    }

    /**
     * @author Jonas Vicente
     * @return Route
     */
    private function getRoute(): Route
    {
        /**
         * Rotas sem path parameter
         * @var ?Route $route
         */
        $route = @$this->router->getRoutes(false)[$this->url];
        if ($route !== null) return $route;

        /**
         * Nome da rota declarada
         * @var string $routeName
         *
         * Objeto da rota declarada
         * @var Route $route
         */
        foreach (@$this->router->getRoutes(true) as $routeName => $route) {
            $routeParts = explode('/', $routeName);

            if (count($this->urlParts) === count($routeParts)) {
                $urlParts = $this->urlParts;

                foreach (array_keys($route->pathParams) as $key) {
                    unset($urlParts[$key]);
                    unset($routeParts[$key]);
                }

                if ($urlParts === $routeParts) return $route;
            }
        }

        http_response_code(404);
        exit(json_encode(["message" => "Not Found"]));
    }
}
