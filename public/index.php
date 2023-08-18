<?php

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
});

$serviceContainer = new \app\ServiceContainer();

$request = new \app\Http\Request\HttpRequest();
$route = new \app\Router($request);

$serviceContainer->resolve(app\App::class)();
