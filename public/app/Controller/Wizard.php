<?php

namespace app\Controller;

use app\Http\Request\Request;
use app\Http\Response\Response;
use app\Service\Configuration\MainConfiguration;

class Wizard
{
    public function __construct(private readonly \app\Service\Configuration\Wizard $wizard)
    {

    }
    /**
     * @throws \Exception
     */
    public function getAction(Request $request): Response
    {
        return $this->wizard->execute();
    }

    /**
     * @throws \Exception
     */
    public function postAction(Request $request): Response
    {
        return $this->wizard->execute();
    }
}
