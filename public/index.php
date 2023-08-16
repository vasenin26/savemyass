<?php

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
});

$request = new \app\Http\Request\HttpRequest();
$route = new \app\Router($request);

(new \app\App($route))();