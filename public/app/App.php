<?php

namespace app;

use app\Http\Response\ErrorPage;
class App
{
    public function __invoke()
    {
        $router = new \app\Router();

        try {
            $controller = $router->getController();
            $method = $router->getAction();

            $response = $controller->$method();
        } catch (\Exception $e) {
            $response = new ErrorPage($e);
        }

        echo $response->getContent();
    }
}