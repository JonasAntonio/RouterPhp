<?php

namespace Src;

class Runner
{
    private string $url;
    private Request $request;
    private Router $router;

    public function __construct(Router $router)
    {
        $this->request = new Request();
        $this->router  = $router;
        $this->url     = Str::setUrlPattern($this->request->getUrl());
    }

    /**
     * Executa o projeto
     * @author Jonas Vicente
     * @return void
     */
    public function run(): void
    {
        $route = $this->getRoute();


        // MiddlewareRunner::validate($route->getBefore());

        $params = [$this->request];
        if ($route->pathParams !== []) {
            $urlParts = explode("/", $this->url);
            foreach ($route->pathParams as $paramKey => $paramName) {
                $params[] = $urlParts[$paramKey];
            }
        }

        echo call_user_func_array($route->getCallback(), $params);
        // MiddlewareRunner::validate($route->getAfter());
    }

    /**
     * @author Jonas Vicente
     * @return Route
     */
    private function getRoute(): Route
    {
        $routes = $this->router->getRoutesByMethod($this->request->getMethod());

        $withoutPathParam = @$routes[false][$this->url];

        if ($withoutPathParam !== null) return $withoutPathParam;

        $urlParts = explode("/", $this->url);
        $withPathParam = @$routes[true];

        foreach ($withPathParam as $name => $routeObj) {
            $registeredRouteParts = explode('/', $name);
            if (count($urlParts) === count($registeredRouteParts)) {
                $routeParams = $routeObj->pathParams;
                foreach ($routeParams as $paramKey => $paramName) {
                    if ($registeredRouteParts[$paramKey] === $paramName) {
                        return $routeObj;
                    }
                }
            }
        }

        http_response_code(404);
        exit(json_encode(["message" => "Not Found"]));
    }
}
