<?php

namespace app\Controller;

use app\Http\Response\ProtectedPage;
use app\Http\Response\Response;
use app\Service\Configuration\Configuration;
use app\Service\Publisher\Publisher;

class Main
{
    /**
     * @throws \Exception
     */
    public function getAction(Resquest $resquest): Response
    {
        $configuration = new Configuration();

        if ($configuration->isConfigured()) {
            if ($configuration->isPublish()) {
                return (new Publisher())->getPublicPage();
            }

            return new ProtectedPage();
        }

        return $configuration->getWizard()->getPage($resquest);
    }
}