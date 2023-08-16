<?php

namespace app;

class Router
{
    public function __construct(private readonly Http\Request\Request $request)
    {

    }

    /**
     * @throws \Exception
     */
    public function getController()
    {
        $path = $this->request->getUri();
        $controller = $this->resolveController($path);

        return new $controller;
    }

    public function getAction(): string
    {
        return 'getAction';
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