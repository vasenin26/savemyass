<?php

spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
});

$serviceContainer = new \app\ServiceContainer();

$serviceContainer->resolve(app\App::class)();
