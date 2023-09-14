<?php

namespace app;

use app\Http\Request\HttpRequest;

class Router
{
    public const GET_ACTION = 'getAction';
    public const POST_ACTION = 'postAction';

    public function __construct(private readonly Http\Request\Request $request)
    {

    }

    /**
     * @throws \Exception
     */
    public function getController(): string
    {
        $path = $this->request->getUri();
        return $this->resolveController($path);
    }

    public function getAction(): string
    {
        return [
            HttpRequest::METHOD_GET => self::GET_ACTION,
            HttpRequest::METHOD_POST => self::POST_ACTION,
        ][$this->request->getMethod()];
    }

    private function resolveController(string $path): string
    {
        $controllerName = [
            '/' => Controller\Main::class,
            '/wizard' => Controller\Wizard::class,
            '/configure' => Controller\Configuration::class,
            '/s' => Controller\Prolongation::class
        ][$path] ?? null;

        if (!$controllerName) {
            throw new \Exception('Controller not found', 404);
        }

        return $controllerName;
    }
}
