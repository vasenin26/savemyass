<?php

namespace app;

use app\Http\Response\ErrorPage;
use app\Service\Configuration\MainConfiguration;

class App
{
    public function __construct(
        private readonly ServiceContainer $serviceContainer,
        private readonly Router           $router
    ) {

    }

    public function __invoke()
    {
        try {
            $method = $this->router->getAction();
            $controllerName = $this->router->getController();
            $controller = $this->serviceContainer->resolve($controllerName);
            $response = $this->serviceContainer->call($controller, $method);
        } catch (\Exception $e) {
            $response = new ErrorPage($e);
        }

        foreach($response->getHeaders() as $header) {
            header($header);
        }

        echo $response->getContent();
    }
}
