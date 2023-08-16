<?php

namespace app\Controller;

use app\Http\Response\ProtectedPage;
use app\Http\Response\Response;
use app\Http\Request\Request;
use app\Service\Configuration\Configuration;
use app\Service\Configuration\Wizard;
use app\Service\Publisher\Publisher;

final class Main extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function getAction(Request $request): Response
    {
        if ($this->configuration->isConfigured()) {
            if ($this->configuration->isPublish()) {
                return (new Publisher())->getPublicPage();
            }

            return new ProtectedPage();
        }

        return $this->getConfigurationWizard()->getPage($request);
    }

    private function getConfigurationWizard(): Wizard
    {
        return new Wizard($this->configuration);
    }
}