<?php

require_once ('vendor/autoload.php');

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../public/' . str_replace('\\', '/', $class) . '.php';
    if(is_file($path)) {
        require_once $path;
    }
});