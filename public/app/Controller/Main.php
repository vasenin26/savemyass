<?php

namespace app\Controller;

use app\Http\Response\ProtectedPage;
use app\Http\Response\Redirect;
use app\Http\Response\Response;
use app\Http\Request\Request;
use app\Service\Configuration\MainConfiguration;
use app\Service\Publisher\Publisher;

final class Main
{
    public function __construct(private readonly MainConfiguration $configuration, private readonly Publisher $publisher)
    {

    }
    /**
     * @throws \Exception
     */
    public function getAction(Request $request): Response
    {
        if ($this->configuration->isConfigured()) {
            if ($this->configuration->isPublish()) {
                $this->publisher->publish();
                return $this->publisher->getPublicPage();
            }

            return new ProtectedPage();
        }

        return new Redirect('/wizard');
    }
}
