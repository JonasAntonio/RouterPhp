<?php

namespace Middleware;

use Src\Route;

class MiddlewareRunner
{
    /**
     * @param array $middlewares coleção de middlewares
     * @return void
     */
    private function validate(array $middlewares): void
    {
        /**
         * @var MiddlewareInterface $middleware
         */
        foreach ($middlewares as $middleware) {
            $middleware->handle();
        }
    }

    public function before(Route $route): void
    {
        $this->validate($route->before);
    }

    public function after(Route $route): void
    {
        $this->validate($route->after);
    }
}
