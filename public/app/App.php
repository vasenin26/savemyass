<?php

namespace app;

use app\Http\Response\ErrorPage;
use app\Service\Configuration\Configuration;

class App
{
    public function __construct(private readonly Configuration $configuration, private readonly Router $router) {

    }

    public function __invoke()
    {
        try {
            $controllerName = $this->router->getController();
            $controller = $this->createController($controllerName);
            $method = $this->router->getAction();

            $response = $controller->$method();
        } catch (\Exception $e) {
            $response = new ErrorPage($e);
        }

        echo $response->getContent();
    }

    private function createController(string $controllerName)
    {
        return new $controllerName($this->configuration);
    }
}