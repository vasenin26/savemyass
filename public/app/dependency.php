<?php

return [
    app\Service\Configuration\MainConfiguration::class => function () {
        $storage = new \app\Storage\ConfigurationFile('config.ini');
        return new \app\Service\Configuration\Configuration($storage);
    },
    app\Http\Request\Request::class => \app\Http\Request\HttpRequest::class,
    app\Service\Publisher\Publisher::class => app\Service\Publisher\DataPublisher::class,
    app\I18n\I18n::class => function () {
        $session = \app\Storage\Session::getInstance();
        return \app\I18n\I18n::setLanguage($session->getOption(\app\Storage\Session::OPTION_LANG) ?? 'en');
    },
    app\Storage\Session::class => function () {
        return \app\Storage\Session::getInstance();
    }
];
