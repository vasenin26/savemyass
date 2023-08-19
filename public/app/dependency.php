<?php

return [
    app\Service\Configuration\MainConfiguration::class => function () {
        $storage = new \app\Storage\ConfigurationFile('config.ini');
        return new \app\Service\Configuration\Configuration($storage);
    },
    app\Http\Request\Request::class => function () {
        return new \app\Http\Request\HttpRequest();
    },
    app\Service\Publisher\DataPublisher::class => app\Service\Publisher\Publisher::class
];
