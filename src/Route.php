<?php

namespace Src;

use Closure;
use Middleware\MiddlewareInterface;

class Route
{
    public Closure $callback;
    public array $pathParams = [];
    public array $before = [];
    public array $after = [];

    public function __construct(Closure $callback, array $pathParams)
    {
        $this->callback = $callback;
        $this->pathParams = $pathParams;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function before(MiddlewareInterface $middleware)
    {
        $this->before[] = $middleware;
        return $this;
    }

    public function after(MiddlewareInterface $middleware)
    {
        $this->after[] = $middleware;
        return $this;
    }
}
