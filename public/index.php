<?php

include __DIR__ . '/app/bootstrap.php';

$serviceContainer = new \app\ServiceContainer();

$serviceContainer->resolve(app\App::class)();
