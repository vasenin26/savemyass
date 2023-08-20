<?php

namespace app;

use app\Http\Response\ErrorPage;
use app\I18n\I18n;
use app\Service\Configuration\MainConfiguration;
use app\Storage\Session;

class App
{
    public function __construct(
        private readonly ServiceContainer $serviceContainer,
        private readonly Router           $router,
        private readonly Session          $session
    ) {

    }

    public function __invoke()
    {
        I18n::setLanguage($this->session->getOption(Session::OPTION_LANG) ?? 'en');

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
