<?php

namespace app;

use app\Http\Response\ErrorPage;
class App
{
    public function __construct(private readonly Router $router) {

    }

    public function __invoke()
    {
        try {
            $controller = $this->router->getController();
            $method = $this->router->getAction();

            $response = $controller->$method();
        } catch (\Exception $e) {
            $response = new ErrorPage($e);
        }

        echo $response->getContent();
    }
}