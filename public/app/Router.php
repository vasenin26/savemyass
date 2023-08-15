<?php

namespace app;

class Router
{
    public function __construct()
    {

    }

    /**
     * @throws \Exception
     */
    public function getController()
    {
        $path = $this->getPath();
        $controller = $this->resolveController($path);

        return new $controller;
    }

    public function getAction(): string
    {
        return 'getAction';
    }

    private function getPath(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    private function resolveController(string $path): string
    {
        $controllerName = [
            '/' => Controller\Main::class,
            '/s' => Controller\Prolongation::class
        ][$path] ?? null;

        if (!$controllerName) {
            throw new \Exception('Controller not found', 404);
        }

        return $controllerName;
    }
}