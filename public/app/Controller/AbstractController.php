<?php

namespace app\Controller;

use app\Service\Configuration\Configuration;

abstract class AbstractController
{
    public function __construct(protected readonly Configuration $configuration)
    {

    }
}
