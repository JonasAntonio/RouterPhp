<?php

namespace Middleware;

/**
 * interface MiddlewareInterface Padroniza o modelo de middlewares para implementação
 */

interface MiddlewareInterface
{
    /**
     * Executa o tratamento do middleware
     *
     * @param array $params
     * @return void
     * @throws Throwable
     */
    public function handle(array $params = []): void;
}
