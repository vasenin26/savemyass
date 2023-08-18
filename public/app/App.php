<?php

namespace app;

use app\Http\Response\ErrorPage;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\MainConfiguration;

class App
{
    public function __construct(private ServiceContainer $serviceContainer, readonly MainConfiguration $configuration, private readonly Router $router)
    {

    }

    public function __invoke()
    {
        try {
            $controllerName = $this->router->getController();
            $controller = $this->serviceContainer->resolve($controllerName);
            $method = $this->router->getAction();

            $response = $controller->$method();
        } catch (\Exception $e) {
            $response = new ErrorPage($e);
        }

        echo $response->getContent();
    }
}
